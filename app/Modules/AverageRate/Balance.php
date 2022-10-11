<?php

namespace App\Modules\AverageRate;

use App\Models\Constants\CurrencyConstant;
use Illuminate\Support\Facades\DB;

/**
 * Остатки по картам и кошелькам сгруппированные и отсортированные по дате и валюте.
 *
 * @package App\Modules\AverageRate
 */
class Balance
{
    /**
     * Остатки по боксам.
     *
     * array:76 [▼
     *      0 => array:3 [▼
     *          "balance_date" => "2021-04-30"
     *          "currency_id" => 2
     *          "balance" => 46814.39
     *      ]
     *      1 => array:3 [▼
     *          "balance_date" => "2021-04-30"
     *          "currency_id" => 4
     *          "balance" => 140.93
     *      ]
     *      2 => array:3 [▼
     *          "balance_date" => "2021-04-30"
     *          "currency_id" => 23
     *          "balance" => 50.0
     *      ]
     *  ...
     *
     * @var array
     */
    private $balance;

    /**
     * Извлекает и сохраняет остатки по боксам сгруппированные и отсортированные по дате и валюте.
     */
    public function __construct()
    {
        $this->balance = DB::table('box_balance as bb')
            ->select(DB::raw("
                bb.balance_date as balance_date,
                d.currency_id as currency_id,
                SUM( TRIM( bb.balance_amount ) + 0 ) as balance
            "))
            ->leftJoin('box as b', 'bb.box_id', '=', 'b.id')
            ->leftJoin('direction as d', 'b.direction_id', '=', 'd.id')
            ->where('d.currency_id', '<>', CurrencyConstant::RUB)
            ->groupByRaw('balance_date, currency_id')
            ->orderBy('balance_date')
            ->orderBy('currency_id')
            ->get()
            ->map( function ( $item ) {
                return (array)$item;
            })
            ->toArray();
    }

    /**
     * Возвращает остатки на боксах сгруппированные и отсортированные по дате и валюте.
     *
     * @return array
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * По дате и валюте находит остаток. А если не находит то возвращает not_found.
     *
     * @param string $balanceDate
     * @param int $currencyId
     * @return mixed|string
     */
    public function findBalance( string $balanceDate, int $currencyId )
    {
        $foundBalance = 'not_found';
        $i = 0;
        while ( $i < count( $this->balance ) ) {
            if ( $this->balance[$i]['balance_date'] === $balanceDate && $this->balance[$i]['currency_id'] === $currencyId ) {
                $foundBalance = $this->balance[$i]['balance'];
                break;
            }
            $i++;
        }
        return $foundBalance;
    }
}
