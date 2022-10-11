<?php

namespace App\Http\Controllers;

use App\Http\Requests\DuplicateBoxBalance;
use App\Http\Requests\StoreBoxBalance;
use App\Http\Requests\UpdateBoxBalance;
use App\Models\Offer;
use App\Repositories\BoxBalanceRepositoryInterface;
use App\Repositories\BoxRepositoryInterface;
use App\Repositories\MoneyMovementRepository;
use App\Repositories\MoneyMovementRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Exception;
use App\Traits\ExceptionSQL;
use App\Models\Books\Box;
use App\Models\BoxBalance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class BoxBalanceController
 *
 * @package App\Http\Controllers
 */
class BoxBalanceController extends Controller
{
    use ExceptionSQL;

    /**
     * @var BoxBalanceRepositoryInterface
     */
    private $boxBalanceRepository;

    /**
     * @var BoxRepositoryInterface
     */
    private $boxRepository;

    /**
     * @var MoneyMovementRepositoryInterface
     */
    private $moneyMovement;

    /**
     * BoxBalanceController constructor.
     *
     * @param BoxBalanceRepositoryInterface $boxBalanceRepository
     * @param BoxRepositoryInterface $boxRepository
     * @param MoneyMovementRepositoryInterface $moneyMovement
     */
    public function __construct(
        BoxBalanceRepositoryInterface $boxBalanceRepository,
        BoxRepositoryInterface $boxRepository,
        MoneyMovementRepositoryInterface $moneyMovement
    )
    {
        $this->boxBalanceRepository = $boxBalanceRepository;
        $this->boxRepository = $boxRepository;
        $this->moneyMovement = $moneyMovement;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index( Request $request ): View
    {
        if ( $request->isMethod('post') ) {
            $request->session()->put( 'box-balance_filter_date', $request->filter_date );
        } else {
            if ( ! session()->has('box-balance_filter_date') ) {
                $request->session()->put( 'box-balance_filter_date', Carbon::now()->format('Y-m-d') );
            }
        }

        $listBoxBalance = $this->boxBalanceRepository->getList();

        return view('box-balance.index', compact('listBoxBalance'));
    }

    /**
     * Сбросить фильтр.
     *
     * @return RedirectResponse
     */
    public function resetFilter(): RedirectResponse
    {
        Session::forget('box-balance_filter_date');

        return redirect('box-balance');
    }

    /**
     * Возвращает лист прихода/расхода для ajax-запроса.
     *
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function getList( Request $request )
    {
        $listBoxBalance = $this->boxBalanceRepository->getList();

        return Datatables::of( $listBoxBalance )
            ->addIndexColumn()
            ->addColumn('open', function( $row ) {
                return '<a href="' . route('box-balance.edit', ['boxBalance' => $row->id]) . '">
                           Открыть
                        </a>';
            })
            ->addIndexColumn()
            ->addColumn('unique_name', function ( $row ) {
                return $row->box->unique_name;
            })
            ->addIndexColumn()
            ->editColumn('balance_amount', function ( $row ) {
                return view('box-balance.amount-field', ['balanceId' => $row->id, 'balanceAmount' => number_format( $row->balance_amount, 8, '.', ' ' )]);
            })
            ->addIndexColumn()
            ->addColumn('delete', function( $row ) {
                return '<a class="delete-confirm"
                           data-id="'.$row->id.'"
                           data-toggle="modal"
                           data-target="#deleteModal">
                           Удалить
                        </a>';
            })
            ->rawColumns(['open', 'delete'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $listBox = $this->boxRepository->getListBox(null);

        return view('box-balance.show', compact( 'listBox'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBoxBalance $request
     * @return RedirectResponse
     */
    public function store( StoreBoxBalance $request ): RedirectResponse
    {
        try {
            BoxBalance::on()->updateOrCreate(['id' => $request->id], [
                'balance_date'      => $request->balance_date,
                'box_id'            => $request->box_id,
                'balance_amount'    => $request->balance_amount,
            ]);

            return redirect()->route('box-balance.index');

        } catch ( Exception $e ) {
            return back()
                ->withInput()
                ->withErrors( $this->getMessageFilterSQLError( $e ) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BoxBalance $boxBalance
     * @return View
     */
    public function edit( BoxBalance $boxBalance ): View
    {
        $listBox = $this->boxRepository->getListBox(null);
        $listMoneyMovement = $this->moneyMovement->getListDayByBox( $boxBalance->box_id, $boxBalance->balance_date->format('Y-m-d') );

        return view('box-balance.show', compact('boxBalance', 'listBox', 'listMoneyMovement'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BoxBalance $boxBalance
     * @return RedirectResponse
     */
    public function destroy( BoxBalance $boxBalance ): RedirectResponse
    {
        try {
            $boxBalance->delete();
        } catch ( Exception $e ) {
            return back()
                ->withErrors( $this->getMessageFilterSQLError( $e ) );
        }
        return redirect()->route('box-balance.index');
    }

    /**
     * Дублирует строки выбраной даты и возвращает лист с текущей датой.
     *
     * @param DuplicateBoxBalance $request
     * @return RedirectResponse
     */
    public function duplicate( DuplicateBoxBalance $request )
    {
        if ( ! $request->session()->has('box-balance_filter_date') ) {
            return back()
                ->withErrors( 'В фильтре не указана дата с которой будет клонирование остатков.' );
        }

        $this->boxBalanceRepository->duplicate( $request );

        return redirect()->route('box-balance.index');
    }

    /**
     * Обновления остатка.
     *
     * @param UpdateBoxBalance $request
     * @return JsonResponse
     */
    public function updateAmount( UpdateBoxBalance $request ): JsonResponse
    {
        $response['message'] = 'success';
        $frontId = $request->id;
        $frontAmount = $request->amount;

        try {
            $this->boxBalanceRepository->updateAmountById( $frontId, $frontAmount );
            $boxBalance = $this->boxBalanceRepository->getRowById( $frontId );

            $response['balance_amount']     = numberFormat8($boxBalance->balance_amount);
            $response['calculated_balance'] = $boxBalance->calculated_balance;
            $response['difference']         = $boxBalance->difference;
            $response['updated_at']         = date_format( $boxBalance->updated_at, 'Y-m-d H:i:s' );
            $response['updated_full_name']  = $boxBalance->updated_full_name;

        } catch ( Exception $e ) {
            $response['message'] = $this->getMessageFilterSQLError( $e );
        }

        return response()->json( $response );
    }


    public function export(Request $request): View
    {
        $listFormatted = '';

        if ( $request->has('export') ) {
            $date = $request->date ? : date('Y-m-d');
            $delimiter = $request->delimiter;
            $template = $request->template;

            $list = $this->boxBalanceRepository->getListExport($date);
            $listFormattedArray = [];

            switch ( $delimiter ) {
                case 'tab':
                    $separator = "\t";
                    break;
                case 'coma':
                    $separator = ',';
                    break;
                default:
                    $separator = '';
            }

            $templatePattern = str_replace('|', $separator, $template);
            foreach ($list as $k => $item) {
                $bn = strlen($item->box->unique_name) > 4 && is_numeric($item->box->unique_name) ? substr($item->box->unique_name, -4) : $item->box->unique_name;

                $template = str_replace('{EMPTY}', '', $templatePattern);
                $template = str_replace('{DATE}', date('d.m.Y', strtotime($item->balance_date)), $template);
                $template = str_replace('{BOX}', $bn, $template);
                $template = str_replace('{B_AMOUNT}', str_replace('.', ',', $item->balance_amount + 0), $template);
                $listFormattedArray[] = $template;
            }

            $listFormatted = implode(PHP_EOL, $listFormattedArray);
        }

        return view('box-balance.export', compact('listFormatted'));
    }
}
