<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCurrency;
use App\Repositories\CurrencyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Traits\ExceptionSQL;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class InitialRateController extends Controller
{
    use ExceptionSQL;

    /**
     * @var CurrencyRepositoryInterface
     */
    protected $currencyRepository;

    /**
     * InitialRateController constructor.
     *
     * @param CurrencyRepositoryInterface $currencyRepository
     */
    public function __construct( CurrencyRepositoryInterface $currencyRepository )
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $listInitialRate = $this->currencyRepository->getList();

        return view('initial-rate.index', compact('listInitialRate'));
    }

    /**
     * Обновление начальных остатков и курсов валют.
     *
     * @param UpdateCurrency $request
     * @return JsonResponse
     */
    public function update( UpdateCurrency $request ): JsonResponse
    {
        $response['message'] = 'success';
        $frontId = $request->id;
        // "currency-" это удалит
        $frontFieldName = substr( $request->input_class, 9 );
        $frontFieldValue = $request->input_value;

        try {
            $this->currencyRepository->updateField( $frontId, $frontFieldName, $frontFieldValue );
            $response['balance_rub'] = $this->currencyRepository->getBalanceRub( $frontId );
        } catch ( Exception $e ) {
            $response['message'] = $this->getMessageFilterSQLError( $e );
        }

        return response()->json( $response );
    }
}
