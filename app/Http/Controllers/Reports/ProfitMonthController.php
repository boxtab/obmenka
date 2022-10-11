<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Traits\ExceptionSQL;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Reports\ProfitMonthReportInterface;
use App\Reports\ProfitPlanReportInterface;

/**
 * Class ProfitMonthController
 *
 * @package App\Http\Controllers\Reports
 */
class ProfitMonthController extends Controller
{
    use ExceptionSQL;

    /**
     * @var ProfitMonthReportInterface
     */
    private $profitMonthReport;

    /**
     * @var ProfitPlanReportInterface
     */
    private $profitPlanReport;

    /**
     * ProfitMonthController constructor.
     *
     * @param ProfitMonthReportInterface $profitMonthReport
     * @param ProfitPlanReportInterface $profitPlanReport
     */
    public function __construct( ProfitMonthReportInterface $profitMonthReport, ProfitPlanReportInterface $profitPlanReport )
    {
        $this->profitMonthReport = $profitMonthReport;
        $this->profitPlanReport = $profitPlanReport;
    }

    /**
     * Показать доходы за месяц.
     *
     * @param Request $request
     * @return View
     */
    public function index( Request $request ): View
    {
        if ( $request->isMethod('post') ) {
            $request->session()->put( 'report_profit_month_filter_month', $request->filter_month );
        } else {
            if ( ! session()->has('report_profit_month_filter_month') ) {
                $request->session()->put('report_profit_month_filter_month', Carbon::now()->format('Y-m'));
            }
        }

        // Расчитываем доходы за месяц в разрезе дней.
        $this->profitMonthReport->prepareData();
        // Стаистика в разарезе дня.
        $listProfitMonth = $this->profitMonthReport->getList();

        $monthSum = $this->profitMonthReport->getMonthSum();
        $monthForecast = $this->profitMonthReport->getMonthForecast();
        $monthAverage = $this->profitMonthReport->getMonthAverage();

        // Расчитываем планы на месяц.
        $this->profitPlanReport->prepareData();
        // Статистика планов разбитых по группам источников дохода.
        $listProfitPlan = $this->profitPlanReport->getList();

        return view('reports.profit-month.index', compact(
            // Статистика на месяц
            'listProfitMonth',
            'monthSum',
            'monthForecast',
            'monthAverage',

            // Планы на месяц
            'listProfitPlan'
        ));
    }
}
