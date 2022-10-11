<?php

namespace App\Modules\AverageRate;

use App\Models\Books\Currency;
use App\Models\Constants\CurrencyConstant;
use Illuminate\Support\Facades\DB;

/**
 * Начальные остатки заданные в таблице валют.
 *
 * @package App\Modules\AverageRate
 */
class BalanceStart
{
    /**
     * array:36 [▼
     *      0 => array:6 [▼
     *          "currency_date" => "2021-04-30"
     *          "currency_id" => 2
     *          "balance" => "46814.39000000"
     *          "income" => "46814.39000000"
     *          "expense" => "123444.7512320323000000"
     *          "rate" => "2.63689757"
     *      ]
     *      1 => array:6 [▼
     *          "currency_date" => "2021-04-30"
     *          "currency_id" => 3
     *          "balance" => "100.00000000"
     *          "income" => "100.00000000"
     *          "expense" => "7500.5754990000000000"
     *          "rate" => "75.00575499"
     *      ]
     * ...
     *
     * @var array Начальные остатки.
     */
    private $balanceStart;

    /**
     * Извлекает и сохраняет начальные остатки.
     *
     * @param string $currencyDate
     * Дата на которую будут назначены все начальные остатки.
     */
    public function __construct( string $currencyDate )
    {
        $this->balanceStart = Currency::on()
            ->select(DB::raw("
                " . '"' . $currencyDate . '"' . " as currency_date,
                id as currency_id,
                balance as balance,
                balance as income,
                balance * rate as expense,
                rate as rate
            "))
            ->where('id', '<>', CurrencyConstant::RUB)
            ->orderBy('currency_date' , 'ASC')
            ->orderBy('currency_id' , 'ASC')
            ->get()
            ->toArray();
    }

    /**
     * Возвращает начальные остатки.
     *
     * @return array
     */
    public function getBalanceStart()
    {
        return $this->balanceStart;
    }

    /**
     * Из блока балансов возвращает курсы валют.
     *
     * @param array $balanceStart
     *  array:36 [▼
     *      0 => array:6 [▼
     *          "currency_date" => "2021-04-30"
     *          "currency_id" => 2
     *          "balance" => "46814.39000000"
     *          "income" => "46814.39000000"
     *          "expense" => "123444.7512320323000000"
     *          "rate" => "2.63689757"
     *      ]
     *      1 => array:6 [▼
     *          "currency_date" => "2021-04-30"
     *          "currency_id" => 3
     *          "balance" => "100.00000000"
     *          "income" => "100.00000000"
     *          "expense" => "7500.5754990000000000"
     *          "rate" => "75.00575499"
     *      ]
     *  ...
     *
     * @return array
     *  array:36 [▼
     *      2 => "2.63689757"
     *      3 => "75.00575499"
     *      4 => "90.77025964"
     *      5 => "0.00000000"
     *      6 => "204941.60944948"
     *  ...
     *
     */
    public static function getRate( array $balanceStart ): array
    {
        $rates = [];
        foreach ( $balanceStart as $item ) {
            $rates[ $item['currency_id'] ] = $item['rate'];
        }
        return $rates;
    }
}
