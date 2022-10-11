<?php

namespace App\Services;

use App\Models\Constants\IncomeExpenseTypeConstant;
use App\Models\IncomeExpense;
use Illuminate\Support\Facades\DB;

/**
 * Сервис удаления прихода/расхода.
 *
 * Class IncomeExpenseDestroyService
 * @package App\Services
 */
class IncomeExpenseDestroyService
{
    /**
     * Модель (одна строка) прихода/расхода.
     *
     * @var IncomeExpense
     */
    private $incomeExpense;

    /**
     * Массив типов приходов/расходов для выводов средств.
     */
    private const ARRAY_OUTPUT = [
        // Вывод карта/карта
        IncomeExpenseTypeConstant::OUTPUT_CARD_CARD,
        // Вывод карта/нал
        IncomeExpenseTypeConstant::OUTPUT_CARD_CASH,
        // Вывод кошелек/карта
        IncomeExpenseTypeConstant::OUTPUT_WALLET_CARD,
        // Вывод кошелек/кошелек
        IncomeExpenseTypeConstant::OUTPUT_WALLET_WALLET,
        // Вывод обмен (разные валюты)
        IncomeExpenseTypeConstant::OUTPUT_EXCHANGE ,
    ];

    /**
     * Запоминаем переданную модель и вызываем метод маршрутов.
     *
     * @param IncomeExpense $incomeExpense
     */
    public function destroy( IncomeExpense $incomeExpense )
    {
        $this->incomeExpense = $incomeExpense;
        $this->route();
    }

    /**
     * Если тип прихода/расхода не входит в массив выводов средств
     * то вызываем обычное удаление. Иначе удаление обоих парных строк.
     */
    private function route()
    {
        if ( ! in_array( $this->incomeExpense->income_expense_type_id, self::ARRAY_OUTPUT ) ) {
            $this->deleteIncomeExpense();
        } else {
            $this->deleteOutput();
        }
    }

    /**
     * Удаление обычного прихода/расхода.
     */
    private function deleteIncomeExpense()
    {
        $this->incomeExpense->delete();
    }

    /**
     * Удаление прихода/расхода относящегося к выводу средств.
     */
    private function deleteOutput()
    {
        // Если это приход.
        if ( $this->incomeExpense->income_expense == 'income' ) {

            DB::transaction( function() {
                $expenseId = $this->incomeExpense->expense_id;
                // Сначало удаляем приход.
                $this->incomeExpense->delete();

                // Затем удаляем расход.
                IncomeExpense::on()
                    ->where('id', $expenseId)
                    ->delete();
            });

        // Если это расход.
        } else {

            DB::transaction( function() {
                // Сначало удаляем приход.
                IncomeExpense::on()
                    ->where('expense_id', $this->incomeExpense->id)
                    ->delete();

                // Затем удаляем расход.
                $this->incomeExpense->delete();
            });
        }
    }
}
