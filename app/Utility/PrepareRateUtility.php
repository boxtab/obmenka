<?php

namespace App\Utility;

use Illuminate\Support\Facades\Auth;

/**
 * Подготавливает вычисленные курсы валют для сохранения в базу данных.
 *
 * Class PrepareRateUtility
 * @package App\Utility
 */
class PrepareRateUtility
{
    /**
     * Вход:
     *
     *  array:112 [▼
     *      0 => array:6 [▼
     *      "currency_date" => "2021-04-29"
     *      "currency_id" => 2
     *      "balance" => 46814.39
     *      "income" => 46814.39
     *      "expense" => 123444.75123203
     *      "rate" => 2.63689757
     *  ]
     *
     * Выход:
     *
     * array:112 [▼
     *      0 => array:7 [▼
     *      "rate_date" => "2021-04-29"
     *      "currency_id" => 2
     *      "rate" => 2.63689757
     *      "created_at" => Illuminate\Support\Carbon @1622712390 {#1576 ▶}
     *      "updated_at" => Illuminate\Support\Carbon @1622712390 {#1542 ▶}
     *      "created_user_id" => 2
     *      "updated_user_id" => 2
     *  ]
     *
     * @param array $arrayBalance
     * @return array
     */
    public function getPrepareRate( array $arrayBalance ): array
    {
        $arrayRate = [];

        foreach ( $arrayBalance as $balance ) {
            $arrayRate[] = [
                'rate_date'         => $balance['currency_date'],
                'currency_id'       => $balance['currency_id'],
                'rate'              => $balance['rate'],
                'created_at'        => now(),
                'updated_at'        => now(),
                'created_user_id'   => Auth::user()->id,
                'updated_user_id'   => Auth::user()->id,
            ];
        }

        return $arrayRate;
    }
}
