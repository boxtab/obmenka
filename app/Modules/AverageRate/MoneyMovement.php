<?php

namespace App\Modules\AverageRate;

use App\Models\Constants\CurrencyConstant;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Закупка валюты за другие валюты. Закупка сгруппированна и отсортирована по дате и валюте закупке.
 *
 * @package App\Modules\AverageRate
 */
class MoneyMovement
{
    /**
     * Движение денежных средств по заявкам и приходам/расходам.
     *
     * array:2 [▼
     *      0 => array:5 [▼
     *          "work_date" => "2021-05-03"
     *          "currency_id_income" => 37
     *          "currency_id_expense" => 1
     *          "amount_income" => 0.127433075
     *          "amount_expense" => 561336.43841102
     *      ]
     *      1 => array:5 [▼
     *          "work_date" => "2021-05-03"
     *          "currency_id_income" => 41
     *          "currency_id_expense" => 1
     *          "amount_income" => 1207.23
     *          "amount_expense" => 88296.629999309
     *      ]
     * ...
     *
     * @var array
     */
    private $moneyMovement;

    /**
     * Заполняем движение средств.
     *
     * MoneyMovement constructor.
     */
    public function __construct()
    {
        $this->moneyMovement = $this->getMergeBidInxExp();
    }

    /**
     * Возвращает закупки валюты.
     *
     * @return array
     */
    public function getMoneyMovement()
    {
        return $this->moneyMovement;
    }

    /**
     * Возвращает сумму закупки.
     *  amount_income - сколько пришло валюты.
     *  amount_expense - сколько отдали рубля за эту валюту.
     *
     * @param string $workDate Например: '2021-04-30'
     * @param int $currencyIdIncome Например: 2
     * @param array $rates Например: array:36 [▼
     *                                  2 => "2.63689757"
     *                                  3 => "75.00575499"
     *                                  4 => "90.77025964"
     *                                  ...
     *                                ]
     * @return array
     */
    public function getPurchaseSum( string $workDate, int $currencyIdIncome, array $rates ): array
    {
        $purchaseSum = [
            'amount_income' => 0,
            'amount_expense' => 0,
        ];

        $purchase = $this->findPurchase( $workDate, $currencyIdIncome );

        foreach ( $purchase as $item ) {
            $purchaseSum['amount_income'] += $item['amount_income'];
            if ( $item['currency_id_expense'] === CurrencyConstant::RUB ) {
                $purchaseSum['amount_expense'] += $item['amount_expense'];
            } else {
//                Log::info($purchase);
//                if ( is_null( $item['currency_id_expense'] ) ) {
//                    Log::info('asd');
//                } else {
//                    Log::info($item['currency_id_expense']);
//                }

                $purchaseSum['amount_expense'] += $item['amount_expense'] * $rates[ $item['currency_id_expense'] ];
            }
        }

        return $purchaseSum;
    }

    /**
     * По дате и валюте находит закупку этой валюты.
     * Закупка состоит из множества сумм этой валюты. И суммы которые мы отдали с кодами валют.
     *
     * @param string $workDate
     * @param int $currencyIdIncome
     * @return array
     *
     * array:1 [▼
     *  0 => array:3 [▼
     *      "amount_income" => 123645.9686035
     *      "currency_id_expense" => 1
     *      "amount_expense" => 8985908.4335
     *      ]
     *  ]
     */
    public function findPurchase( string $workDate, int $currencyIdIncome ): array
    {
        $purchase = [];
        $i = 0;
        $purchaseIndex = 0;
        $purchaseBlock = false;
        while ( $i < count( $this->moneyMovement ) ) {
            if ( $this->moneyMovement[$i]['work_date'] === $workDate && $this->moneyMovement[$i]['currency_id_income'] === $currencyIdIncome ) {
                $purchaseBlock = true;
                $purchaseIndex = $i;
                $purchase[] = [
                    'amount_income' => $this->moneyMovement[$i]['amount_income'],
                    'currency_id_expense' => $this->moneyMovement[$i]['currency_id_expense'],
                    'amount_expense' => $this->moneyMovement[$i]['amount_expense'],
                ];
            }
            // Если блок закупки уже начали заполнять.
            if ( $purchaseBlock === true ) {
                // Если последний элемент не добавили в блок закупки значит закупка закончена.
                if ( $purchaseIndex < $i ) {
                    break;
                }
            }
            $i++;
        }
        return $purchase;
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
            ->whereNotNull( ['d_get.currency_id', 'd_give.currency_id'] )
            ->groupByRaw('DATE(b.updated_at), d_get.currency_id, d_give.currency_id');
    }

    /**
     * Заявки из базы данных преобразованные в массив.
     *
     * @return array
     */
    public function getRetrieveBid(): array
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
    public function getRetrieveIncExp(): array
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
