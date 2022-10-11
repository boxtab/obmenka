<?php

namespace App\Reports;

use App\Models\Bid;
use App\Models\Constants\CurrencyConstant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Извлечение и обработка доходов сгруппированных по направлению.
 *
 * @package App\Reports
 */
class ProfitDirectionReport extends Reports implements ProfitDirectionReportInterface
{
    /**
     * @var Bid
     */
    protected $model;

    /**
     * @var array Список заявок с посчитанным доходом.
     */
    private $listBid = [];

    /**
     * @var array Итог по заявкам.
     *  Количество операций
     *  Сумма дохода
     *  Разница
     */
    private $totalBid = [
        'count_operation'   => 0,
        'volume'            => 0,
        'profit_amount'     => 0,
    ];

    /**
     * ProfitDirectionReport constructor.
     *
     * @param Bid $model
     */
    public function __construct( Bid $model )
    {
        parent::__construct( $model );
    }

    /**
     * Извлекает заявки из базы данных и вычисляет доход сгруппированные по направлениям.
     */
    private function fetchProfit(): void
    {
        $from = session( 'report_profit_direction_start_date', Carbon::now()->format('Y-m-d') ) . ' 00:00:00';
        $to = session( 'report_profit_direction_end_date', Carbon::now()->format('Y-m-d') ) . ' 23:59:59';

        $this->listBid = DB::table('bid as b')
            ->select(DB::raw("
                CONCAT(ps_get.descr, ' ', c_get.descr) as income_name,
                CONCAT(ps_give.descr, ' ', c_give.descr) as expense_name,
                COUNT(distinct b.id) as count_operation,
                SUM( IF( o.enum_inc_exp = 'inc', o.amount, 0 ) ) as volume,
                SUM(
                    IF( o.enum_inc_exp = 'exp', o.amount, 0 )
                    *
                    (
                        ifnull
                        (
                            (
                                select ar.rate
                                from average_rate as ar
                                where ar.rate_date = DATE(o.updated_at)
                                  and ar.currency_id = d_give.currency_id
                            ),
                            1
                        )
                    )
                ) give_amount,
                null as profit_amount
            "))
            ->leftJoin('direction as d_get', 'b.direction_get_id', '=', 'd_get.id')
            ->leftJoin('payment_system as ps_get', 'd_get.payment_system_id', '=', 'ps_get.id')
            ->leftJoin('currency as c_get', 'd_get.currency_id', '=', 'c_get.id')
            ->leftJoin('direction as d_give', 'b.direction_give_id', '=', 'd_give.id')
            ->leftJoin('payment_system as ps_give', 'd_give.payment_system_id', '=', 'ps_give.id')
            ->leftJoin('currency as c_give', 'd_give.currency_id', '=', 'c_give.id')
            ->rightJoin('offer as o', 'b.id', '=', 'o.bid_id')
            ->whereBetween('b.updated_at', [ $from, $to ] )
            ->where('d_get.currency_id', '=', CurrencyConstant::RUB)
            ->groupByRaw('income_name, expense_name')
            ->orderByRaw('income_name, expense_name')
            ->get()
            ->map( function ( $item ) {
                return (array)$item;
            })
            ->toArray();
    }

    /**
     * Вычисляет разнизу.
     * Разница = доход - расход.
     */
    private function calculateDifference(): void
    {
        for ( $i = 0; $i < count( $this->listBid ); $i++ ) {
            $this->listBid[$i]['profit_amount'] = $this->listBid[$i]['volume'] - $this->listBid[$i]['give_amount'];
        }
    }

    /**
     * Вычисляет итоговую строку.
     */
    private function calculatedTotal(): void
    {
        for ( $i = 0; $i < count( $this->listBid ); $i++ ) {
            $this->totalBid['count_operation'] += $this->listBid[$i]['count_operation'];
            $this->totalBid['volume'] += $this->listBid[$i]['volume'];
            $this->totalBid['profit_amount'] += $this->listBid[$i]['profit_amount'];
        }
    }

    /**
     * Подготовить данные для вывода.
     */
    public function prepareData(): void
    {
        // Извлечь заявки. И вычислить по ним доходы.
        $this->fetchProfit();
        // Вычислить разницу между доходом и расходом.
        $this->calculateDifference();
        // Посчитать итоги.
        $this->calculatedTotal();
    }

    /**
     * Возвращает список заявок с посчитанным доходом.
     *
     * @return array
     */
    public function getList(): array
    {
        return $this->listBid;
    }

    /**
     * Возвращает итоги.
     *
     * @return array
     */
    public function getTotal(): array
    {
        return $this->totalBid;
    }
}

