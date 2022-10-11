<?php

namespace App\Http\Controllers;

use App\Repositories\AverageRateCalcRepositoryInterface;
use App\Repositories\AverageRateRepositoryInterface;
use App\Repositories\CurrencyRepository;
use App\Repositories\CurrencyRepositoryInterface;
use App\Traits\ExceptionSQL;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;

class AverageRateController extends Controller
{
    use ExceptionSQL;

    protected $averageRateRepository;
    protected $averageRateCalcRepository;

    public function __construct( AverageRateRepositoryInterface $averageRateRepository, AverageRateCalcRepositoryInterface $averageRateCalcRepository )
    {
        $this->averageRateRepository = $averageRateRepository;
        $this->averageRateCalcRepository = $averageRateCalcRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $listLastDays = $this->averageRateRepository->getLastDays();
        $fieldNameLastDays = $this->averageRateRepository->getFieldNameLastDays( $listLastDays );
        $pivotAverageRate = $this->averageRateRepository->getPivot( $listLastDays );

        return view( 'average-rate.index', compact('listLastDays', 'fieldNameLastDays', 'pivotAverageRate' ) );
    }

    /**
     * Очистка таблицы средних курсов.
     *
     * @return RedirectResponse
     */
    public function clear(): RedirectResponse
    {
        try {
            $this->averageRateRepository->clear();
        } catch ( Exception $e ) {
            return back()
                ->withErrors( $this->getMessageFilterSQLError( $e ) );
        }
        return redirect()->route('average-rate.index');
    }

    /**
     * Расчет средних курсов.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function build( Request $request ): JsonResponse
    {
        $response['message'] = 'success';

        try {
            $this->averageRateCalcRepository->calc();

        } catch ( Exception $e ) {
            $response['message'] = $this->getMessageFilterSQLError( $e );
        }
        return response()->json( $response );
    }
}
