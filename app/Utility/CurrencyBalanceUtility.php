<?php

namespace App\Utility;

use App\Models\Books\Currency;
use App\Models\Constants\CurrencyConstant;
use Illuminate\Support\Facades\DB;

/**
 * Работа с начальными остатками курсов валют.
 *
 * Class CurrencyBalanceUtility
 * @package App\Utility
 */
class CurrencyBalanceUtility
{
    /**
     * Баланс всех валют кроме рубля.
     *
     * array:37 [▼
     *  0 => array:3 [▼
     *      "currency_id" => 2
     *      "balance_rub" => 1590.18
     *      "balance_currency" => 600.22
     *  ]
     *  1 => array:3 [▼
     *      "currency_id" => 3
     *      "balance_rub" => 52500.11
     *      "balance_currency" => 700.78
     *  ]
     *
     * @var array
     */
    private $balance;

    public function __construct()
    {
        $this->balance = Currency::on()
            ->select(DB::raw("
                id as currency_id,
                trim(balance * rate) + 0 as balance_rub,
                trim(balance) + 0 as balance_currency
            "))
            ->where('id', '<>', CurrencyConstant::RUB)
            ->get()
            ->toArray();
    }

    /**
     * Выводит балансы валют.
     *
     * @return array
     */
    public function getBalance() : array
    {
        return $this->balance;
    }

    /**
     * По id валюты возвращает ее курс в рубле.
     *
     * @param $currencyId
     * @return float|int
     */
    public function getRate( $currencyId )
    {
        $index = $this->searchIndexForCurrencyId( $currencyId );
        return $this->balance[ $index ]['balance_rub'] / $this->balance[ $index ]['balance_currency'];
    }

    /**
     * По id валюты возвращает баланс в рубле.
     *
     * @param int $currencyId
     * @return float
     */
    public function getRub( int $currencyId )
    {
        $index = $this->searchIndexForCurrencyId( $currencyId );
        return $this->balance[ $index ]['balance_rub'];
    }

    /**
     * По id валюты возвращает баланс в валюте.
     *
     * @param int $currencyId
     * @return float
     */
    public function getCurrency( int $currencyId )
    {
        $index = $this->searchIndexForCurrencyId( $currencyId );
        return $this->balance[ $index ]['balance_currency'];
    }

    /**
     * По id валюты устанавливает значение баланса в рубле.
     *
     * @param int $currencyId
     * @param float $balance
     */
    public function setRub( int $currencyId, float $balance )
    {
        $index = $this->searchIndexForCurrencyId( $currencyId );
        $this->balance[ $index ]['balance_rub'] = $balance;
    }

    /**
     * По id валюты устанавливает значение баланса в валюте.
     *
     * @param int $currencyId
     * @param float $balance
     */
    public function setCurrency( int $currencyId, float $balance )
    {
        $index = $this->searchIndexForCurrencyId( $currencyId );
        $this->balance[ $index ]['balance_currency'] = $balance;
    }

    /**
     * По id валюты возвращает индекс в массиве.
     *
     * @param int $currencyId
     * @return int|string|null
     */
    private function searchIndexForCurrencyId( int $currencyId )
    {
        foreach ( $this->balance as $key => $val ) {
            if ( $val['currency_id'] === $currencyId ) {
                return $key;
            }
        }
        return null;
    }
}

