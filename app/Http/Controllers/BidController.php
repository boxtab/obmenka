<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBid;

use App\Models\Bid;
use App\Models\Books\Box;
use App\Models\Books\Client;
use App\Models\Books\TopDestinations;
use App\Models\Offer;
use App\Models\User;
use App\Repositories\DirectionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Exception;
use App\Traits\ExceptionSQL;
use Illuminate\Support\Facades\DB;
use App\Repositories\BidRepositoryInterface;
use App\Repositories\OfferRepositoryInterface;
use App\Repositories\BoxRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class BidController extends Controller
{
    use ExceptionSQL;

    protected $bidRepository;
    protected $offerRepository;
    protected $boxRepository;
    protected $directionRepository;

    public function __construct(
        BidRepositoryInterface $bidRepository,
        OfferRepositoryInterface $offerRepository,
        BoxRepositoryInterface $boxRepository,
        DirectionRepository $directionRepository)
    {
        $this->bidRepository = $bidRepository;
        $this->offerRepository = $offerRepository;
        $this->boxRepository = $boxRepository;
        $this->directionRepository = $directionRepository;
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
            $request->session()->put( 'bid_filter_start_date', $request->start_date );
            $request->session()->put( 'bid_filter_stop_date', $request->stop_date );
            $request->session()->put( 'bid_filter_direction_get_id', $request->direction_get_id );
            $request->session()->put( 'bid_filter_direction_give_id', $request->direction_give_id );
            $request->session()->put( 'bid_filter_bid_number', $request->bid_number );
        }
        $listDirectionGet = $this->directionRepository->getList();
        $listDirectionGive = $this->directionRepository->getList();

        return view('bid.index', compact(
            'listDirectionGet',
            'listDirectionGive',
        ));
    }

    /**
     * Сбросить фильтр.
     *
     * @return RedirectResponse
     */
    public function resetFilter(): RedirectResponse
    {
        Session::forget('bid_filter_start_date');
        Session::forget('bid_filter_stop_date');
        Session::forget('bid_filter_direction_get_id');
        Session::forget('bid_filter_direction_give_id');
        Session::forget('bid_filter_bid_number');

        return redirect('bid');
    }


    /**
     * Возвращает список заявок для листа.
     *
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function getBidList( Request $request )
    {
        $listBid = $this->bidRepository->getListBid();

        return Datatables::of( $listBid )
            ->addIndexColumn()
            ->addColumn('open', function( $row ) {
                return '<a href="' . route('bid.edit', ['bid' => $row->id]) . '">
                            Открыть
                        </a>';
            })
            ->addIndexColumn()
            ->addColumn('delete', function( $row ) {
                return '<a
                            class="delete-confirm"
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
        $bid = null;
        $listTopDestinations = TopDestinations::all();
        $listUser = User::all();
        $listClient = Client::all();

        $listBoxGet = Box::all();
        $listBoxGive = Box::all();

        return view('bid.show', compact(
            'bid',
            'listTopDestinations',
            'listUser',
            'listClient',
            'listBoxGet',
            'listBoxGive',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBid $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store( StoreBid $request )
    {
        try {
            $bidData = [
                'bid_number'            => $request->bid_number,
                'top_destinations_id'   => $request->top_destinations_id != 0 ?: null,
                'client_id'             => $request->client_id != 0 ?: null,
                'manager_user_id'       => $request->manager_user_id != 0 ?: null,
                'note'                  => $request->note,
            ];
            if ( ! is_null( $request->updated_at ) ) {
                $bidData += ['updated_at' => $request->updated_at];
            }

            $bid = DB::transaction( function() use ( $request, $bidData ) {
                $bid = Bid::on()
                    ->updateOrCreate(['id' => $request->id], $bidData);

                Offer::on()
                    ->where('bid_id', $bid->id)
                    ->update([ 'updated_at' => $bid->updated_at ]);

                return $bid;
            });

            return redirect()->route('bid.edit', $bid->id);

        } catch ( Exception $e ) {
            return back()
                ->withInput()
                ->withErrors($this->getMessageFilterSQLError($e));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Bid $bid
     * @return View
     */
    public function edit( Bid $bid ): View
    {
        $listTopDestinations = TopDestinations::all();
        $listUser = User::all();
        $listClient = Client::all();

        $listBoxGet = $this->boxRepository->getListBox( $bid->direction_get_id );
        $listBoxGive = $this->boxRepository->getListBox( $bid->direction_give_id );

        $listOfferGet = $this->offerRepository->getListGet( $bid->id );
        $listOfferGive = $this->offerRepository->getListGive( $bid->id );

        $offerGetSum = $listOfferGet->sum('amount');
        $offerGiveSum = $listOfferGive->sum('amount');

        return view('bid.show', compact(
            'bid',
            'listTopDestinations',
            'listUser',
            'listClient',

            'listBoxGet',
            'listBoxGive',

            'listOfferGet',
            'listOfferGive',

            'offerGetSum',
            'offerGiveSum',
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Bid $bid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Bid $bid)
    {
        DB::beginTransaction();

        try {

            Offer::on()->where('bid_id', $bid->id)->delete();
            $bid->delete();
            DB::commit();

        } catch ( Exception $e ) {

            DB::rollback();
            return back()->withErrors( $this->getMessageFilterSQLError( $e ) );

        }

        return redirect()->route('bid.index');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addOffer( Request $request ): JsonResponse
    {
        if ( ! $request->input_amount || $request->input_amount <= 0 ) {
            return response()->json( ['error' => 'Сумма должна быть больше нуля'] );
        }

        $response = [];
        $box = Box::on()->find( $request->box_id );
        $bid = Bid::on()->find( $request->bid_id );
        $dataBidUpdate = [];

        if ( $request->inc_exp == 'inc' && ( ! $bid || ! $bid->direction_get_id ) ) {
            $dataBidUpdate['direction_get_id'] = $box->direction_id;
        }

        if ( $request->inc_exp == 'exp' && ( ! $bid || ! $bid->direction_give_id ) ) {
            $dataBidUpdate['direction_give_id'] = $box->direction_id;
        }

        if ( count($dataBidUpdate) ) {
            $bid = Bid::on()->updateOrCreate( ['id' => $request->bid_id], $dataBidUpdate );
        }

        if ($request->inc_exp == 'inc' && $bid->direction_get_id && $bid->direction_get_id != $box->direction_id) {
            return response()
                ->json( ['error' => 'Счет привязан не к направлению ' . $bid->direction_get_descr]);
        }

        if ($request->inc_exp == 'exp' && $bid->direction_give_id && $bid->direction_give_id != $box->direction_id) {
            return response()
                ->json( ['error' => 'Счет привязан не к направлению ' . $bid->direction_give_descr] );
        }

        $offer = Offer::on()->create([
            'bid_id' => $bid->id,
            'enum_inc_exp' => $request->inc_exp,
            'box_id' => $request->box_id,
            'amount' => $request->input_amount,
            'updated_at' => $bid->updated_at,
        ]);
        $offer = $offer->fresh();

        if ($request->inc_exp == 'inc' && $bid->direction_get_id) {
            $response['box_options'] = (new Box)->getBoxDataFromDirectionId($bid->direction_get_id);
            $response['box_val'] = $offer->box_id;
        }

        if ($request->inc_exp == 'exp' && $bid->direction_give_id) {
            $response['box_options'] = (new Box)->getBoxDataFromDirectionId($bid->direction_give_id);
            $response['box_val'] = $offer->box_id;
        }

        $response['last_insert_id'] = $offer->id;
        $response['box'] = $offer->box->getFormatName();
        $response['amount'] = $offer->amount;
        $response['updated_at'] = $offer->updated_at;
        if ( ! $bid ) {
            // Чтобы при обновлении страницы сотрудником он уже был в заявке
            $response['redirect_url'] = route('bid.edit', $bid->id);
        }
        return response()->json($response);
    }

    /**
     * Удаляет платеж.
     *
     * @param Offer $offer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyOffer(Offer $offer)
    {
        try {
            $offer->delete();
        } catch (Exception $e) {
            return back()->withErrors( $this->getMessageFilterSQLError( $e ) );
        }
        return back()->with('success', ['Платеж из заявки успешно удален.']);
    }

    /**
     * Изменение даты платежа.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateOffer(Request $request)
    {
//        try {
//            Offer::on()
//                ->where( 'id', $request->offer_id )
//                ->first()
//                ->update( ['updated_at' => $request->updated_at] );
//
//        } catch ( Exception $e ) {
//            return back()->withErrors( $this->getMessageFilterSQLError( $e ) );
//        }
//
//        return back()
//            ->with('success', ['Дата платежа успешно обновлена.']);
        null;
    }


    public function export(Request $request): View {
        $listFormatted = '';

        if ( $request->has('export') ) {
            $startDate = $request->get('start_date');
            $stopDate = $request->get('stop_date');
            $delimiter = $request->get('delimiter');
            $template = $request->get('template');

            $list = $this->offerRepository->getListExport($startDate, $stopDate);
            $listBidsNumber = [];
            foreach ($list as $item) {
                $bid = $item->bid_number;
                $bn = is_numeric($item->box_name) ? substr($item->box_name, -4) : $item->box_name;
                $amount = str_replace('.', ',', $item->amount + 0);
                $updated_at = date('d.m.Y', strtotime($item->updated_at));
                $updated_at_unix = strtotime($item->updated_at);
                $is_inc = $item->ie == 'inc';

                if(!isset($listBidsNumber[$bid])) {
                    $listBidsNumber[$bid] = array();
                    $listBidsNumber[$bid][] = array(
                        //'offer_id' => $item->offer_id,
                        //'updated_at_unix' => $updated_at_unix,
                        'bid_number' => $bid,
                        'top_destinations_descr' => $item->top_destinations_descr,
                        'inc_updated_at' => $updated_at,
                        'inc_box_name' => '',
                        'inc_amount' => '',
                        'exp_updated_at' => $updated_at,
                        'exp_box_name' => '',
                        'exp_amount' => '',
                        //'updated_at_unix' => $updated_at_unix,
                    );
                }

                $create_new = true;
                foreach($listBidsNumber[$bid] as $_k => $val){
                    if($is_inc){
                        if(!empty($val['inc_box_name'])) continue;

                        $listBidsNumber[$bid][$_k]['inc_box_name'] = $bn;
                        $listBidsNumber[$bid][$_k]['inc_amount'] = $amount;
                    } else {
                        if(!empty($val['exp_box_name'])) continue;

                        $listBidsNumber[$bid][$_k]['exp_box_name'] = $bn;
                        $listBidsNumber[$bid][$_k]['exp_amount'] = $amount;
                    }
                    $create_new = false;
                    break;
                }

                if($create_new){
                    $listBidsNumber[$bid][] = array(
                        //'offer_id' => $item->offer_id,
                        //'updated_at_unix' => $updated_at_unix,
                        'bid_number' => $bid,
                        'top_destinations_descr' => $item->top_destinations_descr,
                        'inc_updated_at' => $updated_at,
                        'inc_box_name' => $is_inc ? $bn : '',
                        'inc_amount' => $is_inc ? $amount : '',
                        'exp_updated_at' => $updated_at,
                        'exp_box_name' => !$is_inc ? $bn : '',
                        'exp_amount' => !$is_inc ? $amount : '',
                        //'updated_at_unix' => $updated_at_unix,
                    );
                }
            }

            $list = [];
            foreach ($listBidsNumber as $val){
                foreach ($val as $_val){
                    $list[] = $_val;
                }
            }

            switch ($delimiter) {
                case 'tab':
                    $separator = "\t";
                    break;
                case 'coma':
                    $separator = ',';
                    break;
                default:
                    $separator = '';
            }

            $template_pattern = str_replace('|', $separator, $template);
            foreach ($list as $item) {
                $template = str_replace('{EMPTY}', '', $template_pattern);
                $template = str_replace('{BID_NUMBER}', $item['bid_number'], $template);
                $template = str_replace('{TD}', $item['top_destinations_descr'], $template);
                $template = str_replace('{INC_DATE}', $item['inc_updated_at'], $template);
                $template = str_replace('{INC_BOX}', $item['inc_box_name'], $template);
                $template = str_replace('{INC_AMOUNT}', $item['inc_amount'], $template);
                $template = str_replace('{EXC_DATE}', $item['exp_updated_at'], $template);
                $template = str_replace('{EXC_BOX}', $item['exp_box_name'], $template);
                $template = str_replace('{EXC_AMOUNT}', $item['exp_amount'], $template);
                $listFormattedArray[] = $template;
            }

            $listFormatted = implode(PHP_EOL, $listFormattedArray);
        }

        return view('bid.export', compact('listFormatted'));
    }
}
