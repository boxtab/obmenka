<?php

namespace App\Services;

use App\Models\Constants\IncomeExpenseTypeConstant as ie;
use App\Models\IncomeExpense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

/**
 * Сервис сохранения прихода/расхода.
 *
 * Class IncomeExpenseStoreService
 * @package App\Services
 */
class IncomeExpenseStoreService
{
    /**
     * @var array Поля из формы прихода/расхода.
     */
    private $field;

    /**
     * @var Carbon Дата изменения строки.
     */
    private $updatedAt;

    /**
     * @var int id пользователя который проапдэйтил или добавил строку.
     */
    private $updatedUserId;

    /**
     * Определяет относится приход/расход к выводу средств.
     *
     * @return bool
     */
    private function isOutput()
    {
        $incomeExpense = [
            ie::PARTNERS,
            ie::INCOME_UNFINISHED,
            ie::EXPENSE_UNFINISHED,
            ie::COMPANY_EXPENSE,
            ie::COMPANY_INCOME,
        ];

        return ( ! in_array( $this->field['income_expense_type_id'], $incomeExpense ) ) ? true : false;
    }

    /**
     * Направляет кто будет заниматься сохранением.
     *
     * @param array $field
     */
    public function store( array $field )
    {
        $this->field = $field;

        $this->updatedAt = ( empty( $this->field['updated_at'] ) ) ? Carbon::now() : $this->field['updated_at'];
        $this->updatedUserId = Auth::user()->id;

        ( ! $this->isOutput() ) ? $this->saveIncomeExpense() : $this->saveOutput();
    }

    /**
     * Сохраняет приход/расход для:
     *
     * Партнеры
     * Приход незавершенка
     * Расход незавершенка
     * Расход фирмы
     * Приход фирмы
     *
     */
    private function saveIncomeExpense()
    {
        $rowIncomeExpense = [
            'income_expense'            => $this->field['income_expense'],
            'income_expense_type_id'    => $this->field['income_expense_type_id'],
            'box_id'                    => $this->field['box_id'],
            'amount'                    => $this->field['amount'],
            'rate'                      => $this->field['rate'],
            'expense_id'                => null,
            'note'                      => $this->field['note'],
            'updated_at'                => $this->updatedAt,
            'updated_user_id'           => $this->updatedUserId,
        ];

        if ( in_array( $this->field['income_expense_type_id'], [ ie::PARTNERS ] ) ) {
            $rowIncomeExpense +=
                ['partner_id' => $this->field['partner_id']];
        }

        if ( in_array( $this->field['income_expense_type_id'], [ ie::COMPANY_EXPENSE, ie::COMPANY_INCOME ] ) ) {
            $rowIncomeExpense +=
                ['dds_id' => $this->field['dds_id']];
        }

        IncomeExpense::on()->updateOrCreate( [ 'id' => $this->field['id'] ], $rowIncomeExpense );
    }

    /**
     * Сохраняет приход расход для:
     *
     *  Вывод карта/карта
     *  Вывод карта/нал
     *  Вывод кошелек/карта
     *  Вывод кошелек/кошелек
     *  Вывод обмен (разные валюты)
     *
     */
    private function saveOutput()
    {
        DB::transaction( function() {

            // Создаем строку прихода.
            $rowIncome = [
                'income_expense'         => 'income',
                'income_expense_type_id' => $this->field['income_expense_type_id'],
                'dds_id'                 => null,
                'partner_id'             => null,
                'box_id'                 => $this->field['box_income_id'],
                'amount'                 => $this->field['amount_income'],
                'rate'                   => $this->field['rate_income'],
                'expense_id'             => $this->field['expense_id'],
                'note'                   => $this->field['note'],
                'updated_at'             => $this->updatedAt,
                'updated_user_id'        => $this->updatedUserId,
            ];
            $income = IncomeExpense::on()->updateOrCreate( [ 'id' => $this->field['id'] ], $rowIncome );

            // Создаем строку расхода.
            $rowExpense = [
                'income_expense'         => 'expense',
                'income_expense_type_id' => $this->field['income_expense_type_id'],
                'dds_id'                 => null,
                'partner_id'             => null,
                'box_id'                 => $this->field['box_expense_id'],
                'amount'                 => $this->field['amount_expense'],
                'rate'                   => $this->field['rate_expense'],
                'expense_id'             => null,
                'note'                   => null,
                'updated_at'             => $this->updatedAt,
                'updated_user_id'        => $this->updatedUserId,
            ];
            $expense = IncomeExpense::on()->updateOrCreate( [ 'id' => $this->field['expense_id'] ], $rowExpense );

            // В строку прихода записываем id расхода.
            DB::table('income_expense')
                ->where('id', $income->id)
                ->update(['expense_id' => $expense->id]);

        });
    }
}
