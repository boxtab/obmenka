<?php

namespace App\Reports;

use App\Models\Offer;
use App\Models\Constants\CurrencyConstant;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Расчет доходов за месяц.
 *
 *  date_month          Дата, группировка по дате
 *  inc_rub             Приход в рубле
 *  exp_rub             Расход в рубле
 *  client              Клиенты, количество заявок за день
 *  average_check       Средний чек, turnover / client
 *  turnover            Оборот, inc_rub + exp_rub
 *  profit              Доход, inc_rub - exp_rub
 *  percent_profit      Процент доходности, profit / turnover * 100
 *
 * @package App\Reports
 */
class ProfitMonthReport extends Reports implements ProfitMonthReportInterface
{
    /**
     * @var Offer
     */
    protected $model;

    /**
     * @var array Список доходов по дням.
     */
    private $listDay = [];

    /**
     * @var array Сумма за месяц.
     */
    private $monthSum = [
        'client'            => 0,
        'average_check'     => 0,
        'turnover'          => 0,
        'profit'            => 0,
        'percent_profit'    => 0,
    ];

    /**
     * @var array Прогноз за месяц.
     */
    private $monthForecast = [
        'client'            => 0,
        'average_check'     => 0,
        'turnover'          => 0,
        'profit'            => 0,
        'percent_profit'    => 0,
    ];

    /**
     * @var array Среднее значение за месяц.
     */
    private $monthAverage = [
        'client'            => 0,
        'average_check'     => 0,
        'turnover'          => 0,
        'profit'            => 0,
        'percent_profit'    => 0,
    ];

    /**
     * @var string Первый день месяца. Например: "2021-06-01"
     */
    private $startMonth;

    /**
     * @var string Последний день месяца. Например: "2021-06-30"
     */
    private $endMonth;

    /**
     * ProfitMonthReport constructor.
     *
     * @param Offer $model
     */
    public function __construct( Offer $model )
    {
        parent::__construct( $model );
    }

    /**
     * Извлечь доходы и расходы по заявкам.
     *
     * @return Builder
     */
    private function fetchBid(): Builder
    {
        return DB::table('bid as b')
            ->select(DB::raw("
                DATE( b.updated_at ) as date_month,
                SUM( IF( o.enum_inc_exp = 'inc', o.amount, 0 ) ) as inc_rub,
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
                ) exp_rub,
                COUNT( distinct b.id ) as client,
                0 as average_check,
                0 as turnover,
                0 as profit,
                0 as percent_profit
            "))
            ->leftJoin('direction as d_get', 'b.direction_get_id', '=', 'd_get.id')
            ->leftJoin('direction as d_give', 'b.direction_give_id', '=', 'd_give.id')
            ->rightJoin('offer as o', 'b.id', '=', 'o.bid_id')
            ->whereBetween('b.updated_at', [ $this->startMonth, $this->endMonth ] )
            ->where('d_get.currency_id', '=', CurrencyConstant::RUB)
            ->groupByRaw('date_month');
    }

    /**
     * Заявки из таблицы преобразованные в массив.
     *
     * @return array
     */
    public function getBid(): array
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
     *
     * @return Builder
     */
    private function fetchIncomeExpense(): Builder
    {
        return DB::table('income_expense as ie')
            ->select(DB::raw("
                DATE( ie.updated_at ) as date_month,
                SUM( ie.amount * ie.rate ) as inc_rub,
                0 as exp_rub,
                1 as client,
                0 as average_check,
                0 as turnover,
                0 as profit,
                0 as percent_profit
            "))
            ->leftJoin('dds as dds', 'ie.dds_id', '=', 'dds.id')
            ->leftJoin('top_destinations as td', 'dds.top_destinations_id', '=', 'td.id')
            ->whereBetween('ie.updated_at', [ $this->startMonth, $this->endMonth ] )
            ->whereNotNull('dds.top_destinations_id')
            ->where('ie.income_expense', '=', 'income')
            ->groupByRaw('date_month');
    }

    /**
     * Приход/расход из таблицы преобразованный в массив.
     *
     * @return array
     */
    public function getIncomeExpanse(): array
    {
        return $this->fetchIncomeExpense()
            ->get()
            ->map( function ( $item ) {
                return (array)$item;
            })
            ->toArray();
    }

    /**
     * Делаем слияние заявок + приход/расход.
     *
     * @return Builder
     */
    private function mergeBidIncomeExpense(): Builder
    {
        return $this->fetchBid()
            ->union( $this->fetchIncomeExpense() );
    }

    /**
     * Извлекаем операции из базы данных и суммируем доход.
     */
    private function fetchProfit(): void
    {
        $this->listDay = DB::query()->fromSub( $this->mergeBidIncomeExpense(), 'bie' )
            ->select(DB::raw("
                bie.date_month as date_month,
                SUM( bie.inc_rub ) as inc_rub,
                SUM( bie.exp_rub ) as exp_rub,
                SUM( bie.client ) as client,
                SUM( bie.average_check ) as average_check,
                SUM( bie.turnover ) as turnover,
                SUM( bie.profit ) as profit,
                SUM( bie.percent_profit ) as percent_profit
            "))
            ->groupByRaw('bie.date_month')
            ->orderBy('bie.date_month', 'ASC')
            ->get()
            ->map( function ( $item ) {
                return (array)$item;
            })
            ->toArray();
    }

    /**
     * Вычисляемые поля.
     *
     *  average_check       Средний чек, turnover / client
     *  turnover            Оборот, inc_rub + exp_rub
     *  profit              Доход, inc_rub - exp_rub
     *  percent_profit      Процент доходности, profit / turnover * 100
     *
     */
    private function calculatedFields(): void
    {
        for ( $i = 0; $i < count( $this->listDay ); $i++ ) {
            // Средний чек, turnover / client
            $this->listDay[$i]['average_check'] = ( $this->listDay[$i]['inc_rub'] + $this->listDay[$i]['exp_rub'] ) / $this->listDay[$i]['client'];

            // Оборот, inc_rub + exp_rub
            $this->listDay[$i]['turnover'] = $this->listDay[$i]['inc_rub'] + $this->listDay[$i]['exp_rub'];

            // Доход, inc_rub - exp_rub
            $this->listDay[$i]['profit'] = $this->listDay[$i]['inc_rub'] - $this->listDay[$i]['exp_rub'];

            // Процент доходности, profit / turnover * 100
            $this->listDay[$i]['percent_profit'] = $this->listDay[$i]['profit'] / $this->listDay[$i]['turnover'] * 100;
        }
    }

    /**
     * Расчет суммы по колнке.
     *
     *  client              Клиенты
     *  average_check       Средний чек
     *  turnover            Оборот
     *  profit              Доход
     */
    private function calculatedMonthSum(): void
    {
        for ( $i = 0; $i < count( $this->listDay ); $i++ ) {
            $this->monthSum['client']           += $this->listDay[$i]['client'];
            $this->monthSum['average_check']    += $this->listDay[$i]['average_check'];
            $this->monthSum['turnover']         += $this->listDay[$i]['turnover'];
            $this->monthSum['profit']           += $this->listDay[$i]['profit'];
            $this->monthSum['percent_profit']   += $this->listDay[$i]['percent_profit'];
        }
    }

    /**
     * Вычисление прогноза по колнке.
     */
    private function calculatedMonthForecast(): void
    {
        null;
    }

    /**
     * Вычисление среднего значения по колонке.
     */
    private function calculatedMonthAverage(): void
    {
        $countDay = count( $this->listDay ) + 1;

        $this->monthAverage['client']           += $this->monthSum['client'] / $countDay;
        $this->monthAverage['average_check']    += $this->monthSum['average_check'] / $countDay;
        $this->monthAverage['turnover']         += $this->monthSum['turnover'] / $countDay;
        $this->monthAverage['profit']           += $this->monthSum['profit'] / $countDay;
        $this->monthAverage['percent_profit']   += $this->monthSum['percent_profit'] / $countDay;
    }

    /**
     * Подготовить данные для вывода.
     */
    public function prepareData(): void
    {
        // Определяем первый и последний день месяца.
        $monthYear = session('report_profit_month_filter_month');
        $this->startMonth = Carbon::create( $monthYear )->startOfMonth()->toDateString() . ' 00:00:00';
        $this->endMonth = Carbon::create( $monthYear )->endOfMonth()->toDateString() . ' 23:59:59';

        // Извлечь заявки. И вычислить по ним доходы и расходы.
        $this->fetchProfit();
        // Расчет вычисляемых полей.
        $this->calculatedFields();

        // Расчет суммы по колнке.
        $this->calculatedMonthSum();
        // Вычисление прогноза по колнке.
        $this->calculatedMonthForecast();
        // Вычисление среднего значения по колонке.
        $this->calculatedMonthAverage();
    }

    /**
     * Возвращает список операций с посчитанным доходом.
     *
     * @return array
     */
    public function getList(): array
    {
        return $this->listDay;
    }

    /**
     * Возвращает сумму за месяц.
     *
     * @return array
     */
    public function getMonthSum(): array
    {
        return $this->monthSum;
    }

    /**
     * Возвращает прогноз за месяц.
     *
     * @return array
     */
    public function getMonthForecast(): array
    {
        return $this->monthForecast;
    }

    /**
     * Возвращает среднее значение за месяц.
     *
     * @return array
     */
    public function getMonthAverage(): array
    {
        return $this->monthAverage;
    }
}
