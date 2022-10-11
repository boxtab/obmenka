<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Traits\ExceptionSQL;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Reports\ProfitSourceReportInterface;

/**
 * Доходы по источникам доходов.
 *
 * @package App\Http\Controllers\Reports
 */
class ProfitSourceController extends Controller
{
    use ExceptionSQL;

    /**
     * @var ProfitSourceReportInterface
     */
    private $profitSourceReport;

    /**
     * ProfitSourceController constructor.
     *
     * @param ProfitSourceReportInterface $profitSourceReport
     */
    public function __construct( ProfitSourceReportInterface $profitSourceReport )
    {
        $this->profitSourceReport = $profitSourceReport;
    }

    /**
     * Показать доходы по источникам.
     *
     * @param Request $request
     * @return View
     */
    public function index( Request $request ): View
    {
        if ( $request->isMethod('post') ) {
            $request->session()->put( 'report_profit_source_start_date', $request->start_date );
            $request->session()->put( 'report_profit_source_end_date', $request->end_date );
        } else {
            if (
                ( ! session()->has('report_profit_source_start_date') ) &&
                ( ! session()->has('report_profit_source_end_date') )
            ) {
                $request->session()->put('report_profit_source_start_date', Carbon::now()->format('Y-m-d'));
                $request->session()->put('report_profit_source_end_date', Carbon::now()->format('Y-m-d'));
            }
        }

        // Расчитываем доходы по источникам за интервал.
        $this->profitSourceReport->prepareData();
        // Список доходов по источникам.
        $listProfitSource = $this->profitSourceReport->getList();
        // Общие итоги.
        $totalProfitSource = $this->profitSourceReport->getTotal();

        return view('reports.profit-source.index', compact('listProfitSource', 'totalProfitSource'));
    }
}
