<?php

namespace App\Utility;

use App\Models\Constants\CurrencyConstant;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Подготовка данных по движению средств.
 *
 * Class MoneyMovementUtility
 * @package App\Utility
 */
class MoneyMovementUtility
{
    /**
     * Сгруппированное и отсортированное по дате и валюте движение средств.
     *
     * @return array
     */
    public function getMoneyMovement()
    {
        return $this->getMergeBidInxExp();
    }

    /**
     * Извлечь заявки из базы данных.
     *
     * array:2 [▼
     *      0 => array:5 [▼
     *          "work_date" => "2021-05-03"
     *          "currency_id_income" => 37
     *          "currency_id_expense" => 1
     *          "amount_income" => 0.127433075
     *          "amount_expense" => 561336.43841102
     * ]
     */
    private function retrieveBid(): Builder
    {
        return DB::table('bid as b')
            ->select(DB::raw("
                DATE( b.updated_at ) as work_date,
                d_get.currency_id as currency_id_income,
                d_give.currency_id as currency_id_expense,
                SUM( IF( o.enum_inc_exp = 'inc', TRIM(o.amount) + 0, 0 ) ) as amount_income,
                SUM( IF( o.enum_inc_exp = 'exp', TRIM(o.amount) + 0, 0 ) ) as amount_expense
            "))
            ->leftJoin('direction as d_get', 'b.direction_get_id', '=', 'd_get.id')
            ->leftJoin('direction as d_give', 'b.direction_give_id', '=', 'd_give.id')
            ->leftJoin('offer as o', 'b.id', '=', 'o.bid_id')
            ->where('d_get.currency_id', '<>', CurrencyConstant::RUB)
            ->groupByRaw('DATE(b.updated_at), d_get.currency_id, d_give.currency_id');
    }

    /**
     * Заявки из базы данных преобразованные в массив.
     *
     * @return array
     */
    private function getRetrieveBid(): array
    {
        return $this->retrieveBid()
            ->get()
            ->map( function ( $item ) {
                return (array)$item;
            })
            ->toArray();
    }

    /**
     * Извлечь приход/расход из базы данных.
     *
     * array:2 [▼
     *      0 => array:5 [▼
     *          "work_date" => "2021-05-03"
     *          "currency_id_income" => 37
     *          "currency_id_expense" => 1
     *          "amount_income" => 0.127433075
     *          "amount_expense" => 561336.43841102
     * ]
     */
    private function retrieveIncExp(): Builder
    {
        $currencyRub = CurrencyConstant::RUB;

        return DB::table('income_expense as ie')
            ->select(DB::raw("
                DATE( ie.updated_at ) as work_date,
                d.currency_id as currency_id_income,
                $currencyRub as currency_id_expense,
                SUM( TRIM(ie.amount) + 0 ) as amount_income,
                SUM( (TRIM(ie.amount) + 0) * ie.rate ) as amount_expense
            "))
            ->leftJoin('box as b', 'ie.box_id', '=', 'b.id')
            ->leftJoin('direction as d', 'b.direction_id', '=', 'd.id')
            ->where('ie.income_expense' , '=', 'income')
            ->where('d.currency_id' , '<>', CurrencyConstant::RUB)
            ->groupByRaw('DATE( ie.updated_at ), d.currency_id');
    }

    /**
     * Преход/расход из базы данных преобразованный в массив.
     *
     * @return array
     */
    private function getRetrieveIncExp(): array
    {
        return $this->retrieveIncExp()
            ->get()
            ->map( function ( $item ) {
                return (array)$item;
            })
            ->toArray();
    }

    /**
     * Объеденить заявки с приходом/расходом.
     *
     * @return array
     */
    private function getMergeBidInxExp(): array
    {
        $mergeBidIncExp = $this->retrieveBid()
            ->union( $this->retrieveIncExp() );

        return DB::query()->fromSub( $mergeBidIncExp, 'bie' )
            ->select(DB::raw("
                bie.work_date,
                bie.currency_id_income,
                bie.currency_id_expense,
                SUM( bie.amount_income ) as amount_income,
                SUM( bie.amount_expense ) as amount_expense
            "))
            ->groupByRaw('bie.work_date, bie.currency_id_income, bie.currency_id_expense')
            ->orderBy('bie.work_date', 'ASC')
            ->orderBy('bie.currency_id_income', 'ASC')
            ->orderBy('bie.currency_id_expense', 'ASC')
            ->get()
            ->map( function ( $item ) {
                return (array)$item;
            })
            ->toArray();
    }
}
