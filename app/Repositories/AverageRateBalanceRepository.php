<?php

namespace App\Repositories;

use App\Models\AverageRate;
use App\Models\Constants\CurrencyConstant;
use App\Repositories\AverageRateCalcRepositoryInterface;
use App\Repositories\Repositories;
use App\Utility\AverageRateUtility;
use App\Utility\BalanceUtility;
use App\Utility\CurrencyBalanceUtility;
use App\Utility\MoneyMovementUtility;
use App\Utility\PrepareRateUtility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;

class AverageRateBalanceRepository extends Repositories implements AverageRateCalcRepositoryInterface
{
    /**
     * AverageRateRepository constructor.
     *
     * @param AverageRate $model
     */
    public function __construct( AverageRate $model )
    {
        parent::__construct( $model );
    }

    /**
     * Расчет средних курсов и заполнение таблицы средних курсов.
     */
    public function calc()
    {
        // Очистка таблицы средних курсов.
        $this->model->on()->truncate();

        // Начальные остатки плюс остатки по всем картам.
        $mergeInitialBalance = ( new BalanceUtility )->getBalance();

        // Движение по всем картам.
        $moneyMovement = ( new MoneyMovementUtility )->getMoneyMovement();

        // В остатки влиты движение средств.
        $calculatedBalanceMovement = ( new AverageRateUtility( $mergeInitialBalance, $moneyMovement ) )->getRateFromBalanceMoneyMovement();

        // Вычисленные курсы.
        $rate = ( new PrepareRateUtility )->getPrepareRate( $calculatedBalanceMovement );

        DB::table('average_rate')->insert( $rate );
//        AverageRate::on()->insert( $rate );
    }
}
