<?php

namespace App\Http\Controllers;

use App\Helpers\IncomeExpenseHelper;
use App\Http\Requests\StoreIncomeExpense;
use App\Models\Books\Box;
use App\Models\Books\DDS;
use App\Models\IncomeExpense;
use App\Repositories\IncomeExpenseRepositoryInterface;
use App\Services\IncomeExpenseDestroyService;
use App\Services\IncomeExpenseStoreService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Exception;
use App\Traits\ExceptionSQL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\IncomeExpenseExport;

/**
 * Class IncomeExpenseController
 * @package App\Http\Controllers
 */
class IncomeExpenseController extends Controller {
    use ExceptionSQL;

    /**
     * Сервис сохранения в хранилище прихода/расхода.
     *
     * @var IncomeExpenseStoreService
     */
    private $serviceStore;

    /**
     * Сервис удаления прихода/расхода.
     *
     * @var IncomeExpenseDestroyService
     */
    private $serviceDestroy;

    /**
     * Репозиторий для извлечения данных из хранилища прихода/расхода.
     *
     * @var IncomeExpenseRepositoryInterface
     */
    protected $incomeExpenseRepository;

    public function __construct( IncomeExpenseRepositoryInterface $incomeExpenseRepository )
    {
        $this->incomeExpenseRepository = $incomeExpenseRepository;
        $this->serviceStore = new IncomeExpenseStoreService();
        $this->serviceDestroy = new IncomeExpenseDestroyService();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        if ( $request->isMethod('post') ) {
            $request->session()->put('income-expense_filter_start_date', $request->start_date);
            $request->session()->put('income-expense_filter_stop_date', $request->stop_date);
            $request->session()->put('income-expense_filter_income_expense', $request->income_expense);
            $request->session()->put('income-expense_filter_dds_id', $request->dds_id);
            $request->session()->put('income-expense_filter_box_id', $request->box_id);
        }

        $listDDS = DDS::on()->orderBy('id')->get();
        $listBox = Box::on()->orderBy('id')->get();
        $listIncomeExpenseType = constantsInClassToArray('\\App\Models\Constants\IncomeExpenseTypeConstant');

        return view('income-expense.list.index', compact('listDDS', 'listBox', 'listIncomeExpenseType'));
    }

    /**
     * Сбросить фильтр.
     *
     * @return RedirectResponse
     */
    public function resetFilter(): RedirectResponse
    {
        Session::forget('income-expense_filter_start_date');
        Session::forget('income-expense_filter_stop_date');
        Session::forget('income-expense_filter_income_expense');
        Session::forget('income-expense_filter_dds_id');
        Session::forget('income-expense_filter_box_id');

        return redirect('income-expense');
    }

    /**
     * Возвращает лист прихода/расхода.
     *
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function getList(Request $request)
    {
        $listIncomeExpense = $this->incomeExpenseRepository->getList();

        return Datatables::of($listIncomeExpense)
            ->addIndexColumn()
            ->addColumn('open', function ($row) {
                return '<a href="' . route('income-expense.edit', ['incomeExpense' => $row->id]) . '">
                           Открыть
                        </a>';
            })
            ->addIndexColumn()
            ->addColumn('delete', function ($row) {
                return '<a class="delete-confirm"
                           data-id="' . $row->id . '"
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
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $listPartner = null;
        $listBox = null;
        $listDDS = null;
        $listBoxIncome = null;
        $listBoxExpense = null;

        $incomeExpenseTypeId = $request->type;
        $operationTitleName = IncomeExpenseHelper::getOperationDescrById($incomeExpenseTypeId);
        $operationTemplateName = IncomeExpenseHelper::getOperationTemplateById($incomeExpenseTypeId);
        $this->incomeExpenseRepository->getBook(
            $incomeExpenseTypeId,
            $listPartner,
            $listBox,
            $listDDS,
            $listBoxIncome,
            $listBoxExpense
        );
        $isCommentRequired = $this->incomeExpenseRepository->isCommentRequired($incomeExpenseTypeId);

        return view('income-expense.form.show', compact(
            'operationTemplateName',
            'operationTitleName',
            'incomeExpenseTypeId',
            'listPartner',
            'listBox',
            'listDDS',
            'listBoxIncome',
            'listBoxExpense',
            'isCommentRequired',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $this->serviceStore->store($request->except([
                '_token',
                'created_at',
                'created_user_full_name',
                'updated_user_full_name',
            ]));

            return redirect()->route('income-expense.index');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors($this->getMessageFilterSQLError($e));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param IncomeExpense $incomeExpense
     * @return View
     */
    public function edit(IncomeExpense $incomeExpense): View
    {
        $listPartner = null;
        $listBox = null;
        $listDDS = null;
        $listBoxIncome = null;
        $listBoxExpense = null;

        $incomeExpenseTypeId = $incomeExpense->income_expense_type_id;
        $operationTitleName = IncomeExpenseHelper::getOperationDescrById($incomeExpenseTypeId);
        $operationTemplateName = IncomeExpenseHelper::getOperationTemplateById($incomeExpenseTypeId);
        $this->incomeExpenseRepository->getBook(
            $incomeExpenseTypeId,
            $listPartner,
            $listBox,
            $listDDS,
            $listBoxIncome,
            $listBoxExpense
        );
        $isCommentRequired = $this->incomeExpenseRepository->isCommentRequired($incomeExpenseTypeId);

        $incomeId = null;
        $boxIncomeId = null;
        $amountIncome = null;
        $rateIncome = null;
        $expenseId = null;
        $boxExpenseId = null;
        $amountExpense = null;
        $rateExpense = null;
        $this->incomeExpenseRepository->getFieldOutput(
            $incomeExpense,
            $incomeId,
            $boxIncomeId,
            $amountIncome,
            $rateIncome,
            $expenseId,
            $boxExpenseId,
            $amountExpense,
            $rateExpense,
        );

        return view('income-expense.form.show', compact(
            'operationTemplateName',
            'operationTitleName',
            'incomeExpenseTypeId',
            'listPartner',
            'listBox',
            'listDDS',
            'listBoxIncome',
            'listBoxExpense',
            'incomeExpense',
            'isCommentRequired',

            'incomeId',
            'boxIncomeId',
            'amountIncome',
            'rateIncome',
            'expenseId',
            'boxExpenseId',
            'amountExpense',
            'rateExpense',
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param IncomeExpense $incomeExpense
     * @return RedirectResponse
     */
    public function destroy(IncomeExpense $incomeExpense): RedirectResponse
    {
        try {
            $this->serviceDestroy->destroy($incomeExpense);
        } catch (Exception $e) {
            return back()
                ->withErrors($this->getMessageFilterSQLError($e));
        }
        return redirect()->route('income-expense.index');
    }

    /**
     * Экспорт отфильтрованого прихода/расхода.
     *
     * @param Request $request
     * @return View
     */
    public function export(Request $request): View
    {
        $listFormatted = '';

        if ( $request->has('export') ) {
            $startDate = $request->get('start_date');
            $stopDate = $request->get('stop_date');
            $incomeExpense = $request->get('income_expense');

            $list = $this->incomeExpenseRepository->getListExport($startDate, $stopDate, $incomeExpense);
            $listFormattedArray = [];

            switch ($request->delimiter) {
                case 'tab':
                    $separator = "\t";
                    break;
                case 'coma':
                    $separator = ',';
                    break;
                default:
                    $separator = '';
            }

            $template_pattern = str_replace('|', $separator, $request->get('template'));
            foreach ($list as $k => $item) {
                $data = array(
                    'date' => date('d.m.Y', strtotime($item->updated_at)),
                    'income_expense_type_descr' => $item->income_expense_type_descr,
                    'dds_descr' => $item->dds_descr,
                    'box_descr' => $item->box_descr,
                    'amount' => str_replace('.', ',', $item->amount + 0),
                    'comment' => $item->note,
                    'rate' => str_replace('.', ',', $item->rate + 0),
                    'amount_rub' => str_replace('.', ',', $item->amount_rub + 0),
                );

                $template = str_replace('{DATE}', $data['date'], $template_pattern);
                $template = str_replace('{IE_DESC}', $data['income_expense_type_descr'], $template);
                $template = str_replace('{DDS}', $data['dds_descr'], $template);
                $template = str_replace('{BOX}', $data['box_descr'], $template);
                $template = str_replace('{AMOUNT}', $data['amount'], $template);
                $template = str_replace('{COMMENT}', $data['comment'], $template);
                $template = str_replace('{EMPTY}', '', $template);
                $template = str_replace('{RATE}', $data['rate'], $template);
                $template = str_replace('{AMOUNT_RUB}', $data['amount_rub'], $template);
                $listFormattedArray[] = $template;
            }

            $listFormatted = implode(PHP_EOL, $listFormattedArray);
        }

        return view('income-expense.list.export', compact('listFormatted'));
    }

    public function exportTest()
    {
//        $list = $this->incomeExpenseRepository->getListExport( null, null, null );
//        dd($list);
        return Excel::download( new IncomeExpenseExport, 'income-expense.xlsx' );
    }
}
