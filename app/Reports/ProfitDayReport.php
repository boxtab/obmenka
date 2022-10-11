<?php

namespace App\Reports;

use App\Models\Bid;
use App\Models\Constants\CurrencyConstant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Вычислдение дохода за день по заявкам.
 *
 * @package App\Reports
 */
class ProfitDayReport extends Reports implements ProfitDayReportInterface
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
     * @var array Итоговый доход и расход и разница между ними за день по всем заявкам.
     */
    private $totalBid = [
        'income'        => 0,
        'expense'       => 0,
        'difference'    => 0
    ];

    /**
     * ProfitDayReport constructor.
     *
     * @param Bid $model
     */
    public function __construct( Bid $model )
    {
        parent::__construct( $model );
    }

    /**
     * Извлекает заявки из базы данных и вычисляет доход за день по каждой заявкке.
     */
    private function fetchProfit(): void
    {
        $this->listBid = DB::table('bid as b')
            ->select(DB::raw("
                b.id as id,
                b.updated_at as date_bid,
                CONCAT(ps_get.descr, ' ', c_get.descr) as exchange_direction_descr,
                td.descr as top_destinations_descr,
                (
                    select trim(sum(io.amount)) + 0
                    from offer as io
                    where io.bid_id = b.id and io.enum_inc_exp = 'inc'
                ) as income,
                (
                    (
                        select trim(sum(io.amount)) + 0
                        from offer as io
                        where io.bid_id = b.id and io.enum_inc_exp = 'exp'
                    )
                    *
                    (
                        ifnull
                        (
                            (
                                select ar.rate
                                from average_rate as ar
                                where ar.rate_date = '" . session('report_profit_day_filter_date') . "'
                                  and ar.currency_id = d_give.currency_id
                            ),
                            1
                        )
                    )
                ) as expense,
                null as difference
            "))
            ->leftJoin('direction as d_get', 'b.direction_get_id', '=', 'd_get.id')
            ->leftJoin('payment_system as ps_get', 'd_get.payment_system_id', '=', 'ps_get.id')
            ->leftJoin('currency as c_get', 'd_get.currency_id', '=', 'c_get.id')
            ->leftJoin('top_destinations as td', 'b.top_destinations_id', '=', 'td.id')
            ->leftJoin('direction as d_give', 'b.direction_give_id', '=', 'd_give.id')
            ->whereDate('b.updated_at', '=', session('report_profit_day_filter_date') )
            ->where('d_get.currency_id', '=', CurrencyConstant::RUB)
            ->orderBy('b.updated_at', 'ASC')
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
            $this->listBid[$i]['difference'] = $this->listBid[$i]['income'] - $this->listBid[$i]['expense'];
        }
    }

    /**
     * Вычисляет итоговую строку.
     */
    private function calculatedTotal(): void
    {
        for ( $i = 0; $i < count( $this->listBid ); $i++ ) {
            $this->totalBid['income'] += $this->listBid[$i]['income'];
            $this->totalBid['expense'] += $this->listBid[$i]['expense'];
            $this->totalBid['difference'] += $this->listBid[$i]['difference'];
        }
    }

    /**
     * Подготовить данные для вывода.
     */
    public function prepareData(): void
    {
        // Извлечь заявки. И вычислить по ним доходы и расходы.
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

