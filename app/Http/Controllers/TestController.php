<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Books\Box;
use App\Models\BoxBalance;
use App\Models\Constants\IncomeExpenseTypeConstant;
use App\Modules\AverageRate\AverageRate;
use App\Modules\AverageRate\Balance;
use App\Modules\AverageRate\BalanceStart;
use App\Modules\AverageRate\LineDate;
use App\Modules\AverageRate\MoneyMovement;
use App\Repositories\AverageRateCrossRepository;
use App\Utility\BalanceUtility;
use App\Utility\MoneyMovementUtility;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\AverageRateCalcRepositoryInterface;
use App\Repositories\IncomeExpenseRepositoryInterface;
use App\Repositories\CurrencyRepositoryInterface;
use App\Repositories\BoxBalanceRepositoryInterface;
use App\Reports\ProfitDayReportInterface;
use App\Reports\ProfitMonthReportInterface;
use App\Reports\ProfitDirectionReportInterface;
use App\Utility\CurrencyBalanceUtility;
use Illuminate\Support\Facades\Log;
use ReflectionClass;

class TestController extends Controller
{
    protected $averageRateCalcRepository;
    protected $averageRateCalc2Repository;
    protected $incomeExpenseRepository;
    protected $currencyRepository;
    protected $boxBalanceRepository;
    protected $profitDayReport;
    protected $profitMonthReport;
    protected $profitDirectionReport;

    public function __construct(
        AverageRateCalcRepositoryInterface $averageRateCalcRepository,
        AverageRateCalcRepositoryInterface $averageRateCalc2Repository,
        IncomeExpenseRepositoryInterface $incomeExpenseRepository,
        CurrencyRepositoryInterface $currencyRepository,
        BoxBalanceRepositoryInterface $boxBalanceRepository,
        ProfitDayReportInterface $profitDayReport,
        ProfitMonthReportInterface $profitMonthReport,
        ProfitDirectionReportInterface $profitDirectionReport
    )
    {
        $this->averageRateCalcRepository = $averageRateCalcRepository;
        $this->averageRateCalc2Repository = $averageRateCalc2Repository;
        $this->incomeExpenseRepository = $incomeExpenseRepository;
        $this->currencyRepository = $currencyRepository;
        $this->boxBalanceRepository = $boxBalanceRepository;
        $this->profitDayReport = $profitDayReport;
        $this->profitMonthReport = $profitMonthReport;
        $this->profitDirectionReport = $profitDirectionReport;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->profitMonthReport->prepareData();
        dd( $this->profitMonthReport->getIncomeExpanse() );
//        dd( $this->profitMonthReport->getBid() );


    }
}
