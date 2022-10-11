<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportProfitDay;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Traits\ExceptionSQL;
use App\Reports\ProfitDayReportInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

/**
 * Class ProfitDayController
 *
 * @package App\Http\Controllers\Reports
 */
class ProfitDayController extends Controller
{
    use ExceptionSQL;

    /**
     * @var ProfitDayReportInterface
     */
    private $profitDayReport;

    /**
     * ProfitDayController constructor.
     *
     * @param ProfitDayReportInterface $profitDayReport
     */
    public function __construct( ProfitDayReportInterface $profitDayReport )
    {
        $this->profitDayReport = $profitDayReport;
    }

    /**
     * Показать список дохода за день.
     *
     * @param Request $request
     * @return View
     */
    public function index( Request $request ): View
    {
        if ( $request->isMethod('post') ) {
            $request->session()->put( 'report_profit_day_filter_date', $request->filter_date );
        } else {
            if ( ! session()->has('report_profit_day_filter_date') ) {
                $request->session()->put('report_profit_day_filter_date', Carbon::now()->format('Y-m-d'));
            }
        }

        // Расчитываем доход за день по заявкам.
        $this->profitDayReport->prepareData();
        // Список заявок с доходами и расходами.
        $listProfitDay = $this->profitDayReport->getList();
        // Итоги по доходам.
        $totalProfitDay = $this->profitDayReport->getTotal();

        return view('reports.profit-day.index', compact('listProfitDay', 'totalProfitDay'));
    }
}
