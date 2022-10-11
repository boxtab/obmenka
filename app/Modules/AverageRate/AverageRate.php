<?php

namespace App\Modules\AverageRate;

use Illuminate\Support\Facades\Auth;

class AverageRate
{
    /**
     * @var array Средние курсы. Готовые к записи в таблицу.
     */
    private $averageRate = [];

    /**
     * Пушит обработанный блок балансов в средние курсы.
     *
     * @param array $balanceStart
     */
    private function push( array $balanceStart ): void
    {
        foreach ( $balanceStart as $item ) {
            $this->averageRate[] = [
                'rate_date'         => $item['currency_date'],
                'currency_id'       => $item['currency_id'],
                'rate'              => $item['rate'],
                'created_at'        => now(),
                'updated_at'        => now(),
                'created_user_id'   => Auth::user()->id,
                'updated_user_id'   => Auth::user()->id,
            ];
        }
    }

    /**
     * Возвращает обработанные средние курсы.
     *
     * @return array
     */
    public function getAverageRate(): array
    {
        return $this->averageRate;
    }

    public function processing()
    {
        $instanceLineDate = new LineDate();
        $instanceBalance = new Balance();
        $instanceMoneyMovement = new MoneyMovement();
        $instanceBalanceWork = new BalanceStart( $instanceLineDate->getStartDate() );

        $period = $instanceLineDate->getPeriod();
        $balanceWork = $instanceBalanceWork->getBalanceStart();

        foreach ( $period as $day ) {
            $yesterdayRate = BalanceStart::getRate( $balanceWork );

            for ( $i = 0; $i < count( $balanceWork ); $i++ ) {
                // Пересчет курса
                $moneyMovement = $instanceMoneyMovement->getPurchaseSum( $day, $balanceWork[$i]['currency_id'], $yesterdayRate );
                $amountIncome = $moneyMovement['amount_income'];
                $amountExpense = $moneyMovement['amount_expense'];
                if ( $amountIncome != 0 ) {
                    $weightedRub = $balanceWork[$i]['expense'] + $amountExpense;
                    $weightedCurrency = $balanceWork[$i]['income'] + $amountIncome;
                    $balanceWork[$i]['rate'] = $weightedRub / $weightedCurrency;
                }

                // Пересчет баланса
                $balance = $instanceBalance->findBalance( $day, $balanceWork[$i]['currency_id'] );
                if ( $balance != 'not_found' ) {
                    $balanceWork[$i]['balance'] = $balance;
                    $balanceWork[$i]['income'] = $balance;
                    $balanceWork[$i]['expense'] = $balance * $balanceWork[$i]['rate'];

                }

                // Меняем дату.
                $balanceWork[$i]['currency_date'] = $day;
            }

            $this->push( $balanceWork );
        }
    }
}
