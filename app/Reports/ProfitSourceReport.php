<?php

namespace App\Reports;

use App\Models\Bid;
use App\Models\Constants\CurrencyConstant;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Расчет доходов по источникам доходов.
 *
 * top_destinations_id      не видимый  id направления
 * top_destinations_descr   видимый     название направления
 * count_operation          видимый     количество операций
 * volume                   видимый     объем
 * give_amount              не видимый  расход по заявке в рубле
 * profit_amount            видимый     доход = volume - give_amount
 * profit_amount_dds        видимый     Доход по 3 коду ДДС
 * profit_amount_common     видимый     Общий доход = profit_amount + profit_amount_common
 *
 * @package App\Reports
 */
class ProfitSourceReport extends Reports implements ProfitSourceReportInterface
{
    /**
     * @var Bid
     */
    protected $model;

    /**
     * @var array Список доходов по источникам.
     */
    private $listSource = [];

    /**
     * @var array Итого за период по источникам.
     */
    private $totalSource = [
        'count_operation'       => 0,
        'volume'                => 0,
        'profit_amount'         => 0,
        'profit_amount_dds'     => 0,
        'profit_amount_common'  => 0,
    ];

    /**
     * @var string Начало интервала. Например: "2021-06-01 00:00:00"
     */
    private $startDate;

    /**
     * @var string Конец интервала. Например: "2021-06-20 23:59:59"
     */
    private $endDate;

    /**
     * ProfitSourceReport constructor.
     *
     * @param Bid $model
     */
    public function __construct( Bid $model )
    {
        parent::__construct( $model );
    }

    /**
     * Извлечь доходы из заявок и посчитать доходы.
     *
     * @return Builder
     */
    private function fetchBid(): Builder
    {
        return DB::table('bid as b')
            ->select(DB::raw("
                b.top_destinations_id as top_destinations_id,
                td.descr as top_destinations_descr,
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
                0 as profit_amount,
                0 as profit_amount_dds,
                0 as profit_amount_common
            "))
            ->leftJoin('top_destinations as td', 'b.top_destinations_id', '=', 'td.id')
            ->leftJoin('direction as d_get', 'b.direction_get_id', '=', 'd_get.id')
            ->leftJoin('direction as d_give', 'b.direction_give_id', '=', 'd_give.id')
            ->rightJoin('offer as o', 'b.id', '=', 'o.bid_id')
            ->whereBetween('b.updated_at', [ $this->startDate, $this->endDate ] )
            ->where('d_get.currency_id', '=', CurrencyConstant::RUB)
            ->groupByRaw('top_destinations_id, top_destinations_descr');
    }

    /**
     * Заявки из таблицы преобразованные в массив.
     *
     * @return array
     */
    private function getBid(): array
    {
        return $this->fetchBid()
            ->get()
            ->map( function ( $item ) {
                return (array)$item;
            })
            ->toArray();
    }

    /**
     * Извлекает доходы записанные в приходе/расход у которых код ДДС содержит источник дохода.
     * Группирует по источнику дохода.
     *
     * @return Builder
     */
    private function fetchIncomeExpense(): Builder
    {
        return DB::table('income_expense as ie')
            ->select(DB::raw("
                dds.top_destinations_id as top_destinations_id,
                td.descr as top_destinations_descr,
                0 as count_operation,
                0 as volume,
                0 as give_amount,
                0 as profit_amount,
                SUM( ie.amount * ie.rate ) as profit_amount_dds,
                0 as profit_amount_common
            "))
            ->leftJoin('dds as dds', 'ie.dds_id', '=', 'dds.id')
            ->leftJoin('top_destinations as td', 'dds.top_destinations_id', '=', 'td.id')
            ->whereBetween('ie.updated_at', [ $this->startDate, $this->endDate ] )
            ->whereNotNull('dds.top_destinations_id')
            ->where('ie.income_expense', '=', 'income')
            ->groupByRaw('top_destinations_id');
    }

    /**
     * Приход/расход из таблицы преобразованный в массив.
     *
     * @return array
     */
    private function getIncomeExpanse(): array
    {
        return $this->fetchIncomeExpense()
            ->get()
            ->map( function ( $item ) {
                return (array)$item;
            })
            ->toArray();
    }

    private function mergeBidIncomeExpense(): array
    {
        $mergeBidIncExp = $this->fetchBid()
            ->union( $this->fetchIncomeExpense() );

        return DB::query()->fromSub( $mergeBidIncExp, 'bie' )
            ->select(DB::raw("
                bie.top_destinations_id as top_destinations_id,
                bie.top_destinations_descr as top_destinations_descr,
                SUM( bie.count_operation ) as count_operation,
                SUM( bie.volume ) as volume,
                SUM( bie.give_amount ) as give_amount,
                SUM( bie.profit_amount ) as profit_amount,
                SUM( bie.profit_amount_dds ) as profit_amount_dds,
                SUM( bie.profit_amount_common ) as profit_amount_common
            "))
            ->groupByRaw('bie.top_destinations_id, bie.top_destinations_descr')
            ->orderBy('bie.top_destinations_descr', 'ASC')
            ->get()
            ->map( function ( $item ) {
                return (array)$item;
            })
            ->toArray();
    }

    /**
     * Добавит две колонки:
     *  Доход по заявкам.
     *  Общий доход.
     */
    private function addColumnProfitAmountAndProfitAmountCommon(): void
    {
        for ( $i = 0; $i < count( $this->listSource ); $i++ ) {
            // Объем в рубле минус сумма потраченная по зааявке и есть наш доход.
            $this->listSource[$i]['profit_amount'] = $this->listSource[$i]['volume'] - $this->listSource[$i]['give_amount'];

            // Общий доход = заявки + приход/расход.
            $this->listSource[$i]['profit_amount_common'] =
                $this->listSource[$i]['profit_amount'] + $this->listSource[$i]['profit_amount_dds'];
        }
    }

    /**
     * Итоги по столбцам.
     */
    private function calculatedTotalSource(): void
    {
        for ( $i = 0; $i < count( $this->listSource ); $i++ ) {
            $this->totalSource['count_operation'] += $this->listSource[$i]['count_operation'];
            $this->totalSource['volume'] += $this->listSource[$i]['volume'];
            $this->totalSource['profit_amount'] += $this->listSource[$i]['profit_amount'];
            $this->totalSource['profit_amount_dds'] += $this->listSource[$i]['profit_amount_dds'];
            $this->totalSource['profit_amount_common'] += $this->listSource[$i]['profit_amount_common'];
        }
    }

    /**
     * Подготовить данные для вывода.
     */
    public function prepareData(): void
    {
        // Определяем интервал.
        $this->startDate = session('report_profit_source_start_date') . ' 00:00:00';
        $this->endDate = session('report_profit_source_end_date') . ' 23:59:59';

        // Извлекаем и объеденяем заявки и приходы расходы.
        $this->listSource = $this->mergeBidIncomeExpense();

        // Вычислить доход по заявкам + общий доход.
        $this->addColumnProfitAmountAndProfitAmountCommon();

        // Вычислить итоги по колонкам.
        $this->calculatedTotalSource();
    }

    /**
     * Возвращает список операций с посчитанным доходом.
     *
     * @return array|null
     */
    public function getList(): ?array
    {
        return $this->listSource;
    }

    /**
     * Возвращает итоги.
     *
     * @return array|null
     */
    public function getTotal(): ?array
    {
        return $this->totalSource;
    }
}
