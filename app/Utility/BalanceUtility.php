<?php

namespace App\Utility;

use App\Models\Constants\CurrencyConstant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Подготовка остатков.
 *
 * Class BalanceUtility
 * @package App\Utility
 */
class BalanceUtility
{
    /**
     * @var array Остатки из таблицы остатков по боксам.
     */
    private $balance = [];

    /**
     * @var string Дата первого остатка минус один день.
     */
    private $initialDate;

    /**
     * @var array Остатки по валютам.
     */
    private $initialBalance = [];

    /**
     * @var array Начальные остатки по валютам плюс остатки по картам.
     */
    private $mergeInitialBalance = [];

    /**
     * Возвращает сгруппированные и обработанные остатки.
     *
     * @return array
     */
    public function getBalance(): array
    {
        $this->balance = $this->getBalanceByBox();
        $this->initialDate = $this->getInitialDate();
        $this->initialBalance = $this->getInitialBalance();
        $this->mergeInitialBalance = $this->getMergeInitialBalance();

        return $this->mergeInitialBalance;
    }

    /**
     * Возвращает остатки по картам сгруппированные и отсортиррованные по дате и валюте.
     *
     * @return array
     */
    private function getBalanceByBox(): array
    {
        return DB::table('box_balance as bb')
            ->select(DB::raw("
                bb.balance_date as currency_date,
                d.currency_id as currency_id,
                SUM( TRIM( bb.balance_amount ) + 0 ) as balance,
                0 as income,
                0 as expense,
                0 as rate
            "))
            ->leftJoin('box as b', 'bb.box_id', '=', 'b.id')
            ->leftJoin('direction as d', 'b.direction_id', '=', 'd.id')
            ->where('d.currency_id', '<>', CurrencyConstant::RUB)
            ->groupByRaw('currency_date, currency_id')
            ->orderBy('currency_date')
            ->orderBy('currency_id')
            ->get()
            ->map( function ( $item ) {
                return (array)$item;
            })
            ->toArray();
    }

    /**
     * Возвращает дату предшествующую дате первому остатку по карте.
     *
     * @return string
     */
    private function getInitialDate(): string
    {
        $initialDate = Carbon::now()->toDateString();

        if ( ! empty( $this->balance ) ) {
            $initialDate = date('Y-m-d', strtotime('-1 day', strtotime( $this->balance[0]['currency_date'] ) ) );
        }

        return $initialDate;
    }

    /**
     * Начальные остатки по валютам. Дата этих остатков будет. Предыдущий день от первой даты остатков по картам.
     *
     * @return array
     */
    private function getInitialBalance(): array
    {
        return DB::table('currency as c')
            ->select(DB::raw("
                " . '"' . $this->initialDate . '"' . " as currency_date,
                c.id as currency_id,
                TRIM(c.balance) + 0 as balance,
                TRIM(c.balance) + 0 as income,
                TRIM(c.balance * c.rate) + 0 as expense,
                TRIM(c.rate) + 0 as rate
            "))
            ->where('c.id', '<>', CurrencyConstant::RUB)
            ->orderBy('currency_id')
            ->get()
            ->map( function ( $item ) {
                return (array)$item;
            })
            ->toArray();
    }

    /**
     * К массиву начальных остатков по валютам добавляет массив остатков по картам.
     *
     * @return array
     */
    private function getMergeInitialBalance(): array
    {
        return array_merge( $this->initialBalance, $this->balance );
    }
}
