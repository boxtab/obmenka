<?php

namespace App\Http\Controllers\Reports;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Reports\ProfitDirectionReportInterface;
use Illuminate\Http\Request;
use App\Traits\ExceptionSQL;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;

/**
 * Доходы сгруппированные по направлениям.
 *
 * @package App\Http\Controllers\Reports
 */
class ProfitDirectionController extends Controller
{
    use ExceptionSQL;

    /**
     * @var ProfitDirectionReportInterface
     */
    private $profitDirectionReport;

    /**
     * ProfitDirectionController constructor.
     *
     * @param ProfitDirectionReportInterface $profitDirectionReport
     */
    public function __construct( ProfitDirectionReportInterface $profitDirectionReport )
    {
        $this->profitDirectionReport = $profitDirectionReport;
    }

    /**
     * Показать список доходов по направлениям за интервал.
     *
     * @param Request $request
     * @return View
     */
    public function index( Request $request ): View
    {
        if ( $request->isMethod('post') ) {
            $request->session()->put( 'report_profit_direction_start_date', $request->start_date );
            $request->session()->put( 'report_profit_direction_end_date', $request->end_date );
        } else {
            if ( ( ! session()->has('report_profit_direction_start_date') ) &&
                ( ! session()->has('report_profit_direction_end_date') )
            ) {
                $request->session()->put('report_profit_direction_start_date', Carbon::now()->format('Y-m-d'));
                $request->session()->put('report_profit_direction_end_date', Carbon::now()->format('Y-m-d'));
            }
        }


        // Расчитываем доход за день по заявкам.
        $this->profitDirectionReport->prepareData();
        // Список заявок с доходами и расходами.
        $listProfitDirection = $this->profitDirectionReport->getList();
        // Итоги по доходам.
        $totalProfitDirection = $this->profitDirectionReport->getTotal();

        return view('reports.profit-direction.index', compact('listProfitDirection', 'totalProfitDirection'));
    }
}
