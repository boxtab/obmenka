<?php

namespace App\Repositories;

use App\Models\AverageRate;
use App\Models\Constants\CurrencyConstant;
use App\Utility\CurrencyBalanceUtility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;

class AverageRateCalcRepository extends Repositories implements AverageRateCalcRepositoryInterface
{
    /**
     * @var AverageRate
     */
    protected $model;

    /**
     * @var CurrencyBalanceUtility
     */
    private $balance;

    /**
     * @var array
     */
    private $united;

    /**
     * @var array
     */
    private $averageRate = [];

    /**
     * AverageRateRepository constructor.
     *
     * @param AverageRate $model
     */
    public function __construct( AverageRate $model )
    {
        parent::__construct( $model );

        $this->balance = new CurrencyBalanceUtility();
    }

    public function calc()
    {
        $this->model->on()->truncate();
        $this->fillUnited();
        $averageRate = $this->fillAverageRate();

        DB::table('average_rate')->insert( $averageRate );
//        AverageRate::on()->insert( $averageRate );
    }

    /**
     * Извлечь заявки из базы данных.
     *
     * array:16 [▼
     *  0 => array:4 [▼
     *      "work_date" => "2021-03-12"
     *      "currency_id" => 40
     *      "amount_rub" => "63810.00000000"
     *      "amount_currency" => "855.98515800"
     *  ]
     *  1 => array:4 [▼
     *      "work_date" => "2021-03-12"
     *      "currency_id" => 41
     *      "amount_rub" => "1260150.12000000"
     *      "amount_currency" => "17087.28000000"
     *  ]
     */
    public function retrieveBid(): Builder
    {
        return DB::table('bid as b')
            ->select(DB::raw("
                DATE( b.updated_at ) as work_date,
                d_get.currency_id as currency_id,
                SUM( IF( o.enum_inc_exp = 'exp', o.amount, 0 ) ) as amount_rub,
                SUM( IF( o.enum_inc_exp = 'inc', o.amount, 0 ) ) as amount_currency
            "))
            ->leftJoin('direction as d_get', 'b.direction_get_id', '=', 'd_get.id')
            ->leftJoin('direction as d_give', 'b.direction_give_id', '=', 'd_give.id')
            ->leftJoin('offer as o', 'b.id', '=', 'o.bid_id')
            ->where('d_get.currency_id', '<>', CurrencyConstant::RUB)
            ->where('d_give.currency_id', '=', CurrencyConstant::RUB)
            ->groupByRaw('DATE(b.updated_at), d_get.currency_id');
    }

    /**
     * Извлечь приход/расход из базы данных.
     *
     * array:1 [▼
     *  0 => array:4 [▼
     *      "work_date" => "2021-03-17"
     *      "currency_id" => 39
     *      "amount_rub" => "35500.0000000000000000"
     *      "amount_currency" => "0.01000000"
     *  ]
     */
    public function retrieveIncExp(): Builder
    {
        return DB::table('income_expense as ie')
            ->select(DB::raw("
                DATE( ie.updated_at ) as work_date,
                d.currency_id as currency_id,
                SUM( ie.amount * ie.rate ) as amount_rub,
                SUM( ie.amount ) as amount_currency
            "))
            ->leftJoin('box as b', 'ie.box_id', '=', 'b.id')
            ->leftJoin('direction as d', 'b.direction_id', '=', 'd.id')
            ->where('ie.income_expense' , '=', 'income')
            ->where('d.currency_id' , '<>', CurrencyConstant::RUB)
            ->groupByRaw('DATE( ie.updated_at ), d.currency_id');
    }

    /**
     * Объеденить заявки с приходом/расходом.
     */
    public function fillUnited()
    {
        $bidIncomeExpense = $this->retrieveBid()
            ->union( $this->retrieveIncExp() );

        $this->united = DB::query()->fromSub($bidIncomeExpense, 'bid_income_expense')
            ->select(DB::raw('
                work_date,
                currency_id,
                SUM( amount_rub ) as amount_rub,
                SUM( amount_currency ) as amount_currency
            '))
            ->groupByRaw('work_date, currency_id')
            ->orderBy('work_date', 'ASC')
            ->orderBy('currency_id', 'ASC')
            ->get()
            ->map( function ( $item ) {
                return (array)$item;
            })
            ->toArray();
    }

    /**
     * Заполнить средние курсы.
     *
     * Массив на выходе.
     *
     *array:16 [▼
     *  0 => array:3 [▼
     *      "rate_date" => "2021-03-12"
     *      "currency_id" => 40
     *      "balance_amount" => 76.406861007883
     *  ]
     *  1 => array:3 [▼
     *      "rate_date" => "2021-03-12"
     *      "currency_id" => 41
     *      "balance_amount" => 73.747847521665
     *  ]
     */
    // Закомментировал, чтобы шторм не подсвечивал дублирование кода с репозиторием AverageRateCrossRepository.php
/*    public function fillAverageRate()
    {
        foreach ( $this->united as $dailyBalanceByCurrency ) {

            $workDate = $dailyBalanceByCurrency['work_date'];
            $currencyId = $dailyBalanceByCurrency['currency_id'];
            $amountRub = $dailyBalanceByCurrency['amount_rub'];
            $amountCurrency = $dailyBalanceByCurrency['amount_currency'];

            // Вычисляем средневзвешенный остаток.
            $weightedRub = $this->balance->getRub( $currencyId ) + $amountRub;
            $weightedCurrency = $this->balance->getCurrency( $currencyId ) + $amountCurrency;

            // Записываем средневзвешенный остаток в массив остатков по валютам.
            $this->balance->setRub( $currencyId, $weightedRub );
            $this->balance->setCurrency( $currencyId, $weightedCurrency );

            $this->averageRate[] = [
                'rate_date' => $workDate,
                'currency_id' => $currencyId,
                'rate' => $weightedRub / $weightedCurrency,
            ];
        }
        return $this->averageRate;
    }*/
}
