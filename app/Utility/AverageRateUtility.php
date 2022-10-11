<?php

namespace App\Utility;

/**
 * Рассчет средних курсов.
 *
 * Class AverageRateUtility
 * @package App\Utility
 */
class AverageRateUtility
{
    /**
     * @var array Начальные остатки плюс все остатки по боксам сгруппированные по датам и валютам.
     */
    private $balance;

    /**
     * @var array Движение средств сгруппированное по датам и валютам.
     */
    private $money;

    /**
     * AverageRateUtility constructor.
     *
     * @param array $mergeInitialBalance
     *   52 => array:6 [▼
     *      "currency_date" => "2021-05-01"
     *      "currency_id" => 28
     *      "balance" => 2560.19
     *      "income" => 0
     *      "expense" => 0
     *      "rate" => 0
     *  ]
     *
     * @param array $moneyMovement
     *   0 => array:5 [▼
     *      "work_date" => "2021-05-03"
     *      "currency_id_income" => 37
     *      "currency_id_expense" => 1
     *      "amount_income" => 0.127433075
     *      "amount_expense" => 561336.43841102
     *  ]
     *
     */
    public function __construct( array $mergeInitialBalance, array $moneyMovement )
    {
        $this->balance = $mergeInitialBalance;
        $this->money = $moneyMovement;
    }

    /**
     * Рассчет среднего курса.
     *
     * @param float $previousPurchase Предыдущая закупка.
     * @param float $previousPayment Предыдущая оплата.
     * @param float $currentPurchase Текущая закупка.
     * @param float $currentPayment Текущая оплата.
     * @return float|int
     */
    private function calculateAverageRate( float $previousPurchase, float $previousPayment, float $currentPurchase, float $currentPayment )
    {
        $rub = $previousPayment +  $currentPayment;
        $currency = $previousPurchase + $currentPurchase;

        // Деление на ноль запрещено
        if ( $currency === 0 ) {
            return 0;
        }

        return $rub / $currency;
    }

    /**
     * Рассчет средних курсов.
     *
     * @return array
     *   2 => array:6 [▼
     *      "currency_date" => "2021-04-29"
     *      "currency_id" => 4
     *      "balance" => 140.93
     *      "income" => 140.93
     *      "expense" => 12792.252691065
     *      "rate" => 90.77025964
     *  ]
     */
    public function getRateFromBalanceMoneyMovement(): array
    {
        for ( $i = 0; $i < count( $this->balance ); $i++ ) {
            // Предыдущая закупка.
            $previousPurchase = $this->getPreviousPurchase( $i );
            // Предыдущая оплата.
            $previousPayment = $this->getPreviousPayment( $i );
            // Текущая закупка.
            $currentPurchase = $this->getCurrentPurchase( $this->balance[$i]['currency_date'], $this->balance[$i]['currency_id'] );
            // Текущая оплата.
            $currentPayment = $this->getCurrentPayment( $this->balance[$i]['currency_date'], $this->balance[$i]['currency_id'] );

            // Рассчет среднего курса.
            $rate = $this->calculateAverageRate( $previousPurchase, $previousPayment, $currentPurchase, $currentPayment );

            $this->balance[$i]['income'] = $currentPurchase;
            $this->balance[$i]['expense'] = $currentPayment;
            $this->balance[$i]['rate'] = $rate;
        }
        return $this->balance;
    }

    private function getPreviousPurchase( int $index ): float
    {
        return 0;
    }

    private function getPreviousPayment( int $index ): float
    {
        return 0;
    }

    private function getCurrentPurchase( string $currencyDate, int $currencyId ): float
    {
        return 0;
    }

    private function getCurrentPayment( string $currencyDate, int $currencyId ): float
    {
        return 0;
    }

}
