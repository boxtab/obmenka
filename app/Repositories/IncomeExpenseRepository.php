<?php

namespace App\Repositories;

use App\Models\Books\Box;
use App\Models\Books\DDS;
use App\Models\Books\Partners;
use App\Models\Constants\IncomeExpenseTypeConstant as IE;
use App\Models\IncomeExpense;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class IncomeExpenseRepository extends Repositories implements IncomeExpenseRepositoryInterface
{
    /**
     * @var IncomeExpense
     */
    protected $model;

    /**
     * IncomeExpenseRepository constructor.
     *
     * @param IncomeExpense $model
     */
    public function __construct( IncomeExpense $model )
    {
        parent::__construct( $model );
    }

    /**
     * Список прихода и расхода пропущеного через фильтр.
     *
     * @return Collection
     */
    public function getList() : Collection
    {
        return DB::table('income_expense as ie')
            ->select(DB::raw("
                ie.id as id,
                IF(ie.income_expense = 'income', 'Приход', 'Расход') as income_expense,
                t.description as income_expense_type_descr,
                d.descr as dds_descr,
                b.unique_name as box_descr,
                TRIM(ie.amount) + 0 as amount,
                TRIM(ie.rate) + 0 as rate,
                TRIM(ie.amount * ie.rate) + 0 as amount_rub,
                ie.updated_at as updated_at,
                CONCAT(uu.surname, ' ', LEFT(uu.name, 1), '. ', LEFT(uu.patronymic, 1), '.') as updated_full_name
            "))
            ->leftJoin('income_expense_type as t', 'ie.income_expense_type_id', '=', 't.id')
            ->leftJoin('dds as d', 'ie.dds_id', '=', 'd.id')
            ->leftJoin('box as b', 'ie.box_id', '=', 'b.id')
            ->leftJoin('users as uu', 'ie.updated_user_id', '=', 'uu.id')
            ->when( ! is_null( session('income-expense_filter_start_date') ), function ($query) {
                return $query->where('ie.updated_at', '>=', session('income-expense_filter_start_date') . ' 00:00:00');
            })
            ->when( ! is_null( session('income-expense_filter_stop_date') ), function ($query) {
                return $query->where('ie.updated_at', '<=', session('income-expense_filter_stop_date') . ' 23:59:59');
            })
            ->when( ! is_null( session('income-expense_filter_income_expense') ), function ($query) {
                return $query->where('ie.income_expense', session('income-expense_filter_income_expense'));
            })
            ->when( ! is_null( session('income-expense_filter_dds_id') ), function ($query) {
                return $query->where('ie.dds_id', session('income-expense_filter_dds_id'));
            })
            ->when( ! is_null( session('income-expense_filter_box_id') ), function ($query) {
                return $query->where('ie.box_id', session('income-expense_filter_box_id'));
            })
            ->orderBy('ie.id', 'desc')
            ->get();
    }

    public function getListExport(?string $startDate, ?string $stopDate, ?string $incomeExpense) : Collection
    {
        return DB::table('income_expense as ie')
            ->select(DB::raw("
                ie.id as id,
                if(ie.income_expense = 'income', 'Приход', 'Расход') as income_expense,
                t.description as income_expense_type_descr,
                d.descr as dds_descr,
                b.unique_name as box_descr,
                ie.amount as amount,
                ie.rate as rate,
                ie.amount * ie.rate as amount_rub,
                ie.note as note,
                ie.created_at as created_at,
                ie.updated_at as updated_at,
                concat(cu.surname, ' ', LEFT(cu.name, 1), '. ', LEFT(cu.patronymic, 1), '.') as created_full_name,
                concat(uu.surname, ' ', LEFT(uu.name, 1), '. ', LEFT(uu.patronymic, 1), '.') as updated_full_name
            "))
            ->leftJoin('income_expense_type as t', 'ie.income_expense_type_id', '=', 't.id')
            ->leftJoin('dds as d', 'ie.dds_id', '=', 'd.id')
            ->leftJoin('box as b', 'ie.box_id', '=', 'b.id')
            ->leftJoin('users as cu', 'ie.created_user_id', '=', 'cu.id')
            ->leftJoin('users as uu', 'ie.updated_user_id', '=', 'uu.id')
            ->when( ! is_null($startDate), function ($query) use ($startDate) {
                return $query->where('ie.updated_at', '>=', $startDate . ' 00:00:00');
            })
            ->when( ! is_null($stopDate), function ($query) use ($stopDate) {
                return $query->where('ie.updated_at', '<=', $stopDate . ' 23:59:59');
            })
            ->when( ! is_null($incomeExpense), function ($query) use ($incomeExpense) {
                return $query->where('ie.income_expense', $incomeExpense);
            })
            ->orderBy('ie.id', 'desc')
            ->get();
    }


    /**
     * В зависимости типа прихода/расхода заполняем справочники.
     *
     * @param int $incomeExpenseTypeId
     * @param $listPartner
     * @param $listBox
     * @param $listDDS
     * @param $listBoxIncome
     * @param $listBoxExpense
     */
    public function getBook( int $incomeExpenseTypeId, &$listPartner, &$listBox, &$listDDS, &$listBoxIncome, &$listBoxExpense ) : void
    {
        // Партнеры
        if ( in_array( $incomeExpenseTypeId, [IE::PARTNERS] ) ) {
            $listPartner = Partners::on()->orderBy('descr')->get();
        }

        // Партнеры, Приход незавершенка, Расход незавершенка, Расход фирмы, Приход фирмы
        if ( in_array( $incomeExpenseTypeId, [IE::PARTNERS, IE::INCOME_UNFINISHED, IE::EXPENSE_UNFINISHED, IE::COMPANY_EXPENSE, IE::COMPANY_INCOME] ) ) {
            $listBox = Box::on()->orderBy('unique_name')->get();
        }

        // Расход фирмы, Приход фирмы
        if ( in_array( $incomeExpenseTypeId, [IE::COMPANY_EXPENSE, IE::COMPANY_INCOME] ) ) {
            $listDDS = DDS::on()->orderBy('descr')->get();
        }

        // Вывод карта/карта, Вывод карта/нал, Вывод кошелек/карта, Вывод кошелек/кошелек, Вывод обмен (разные валюты)
        if ( in_array( $incomeExpenseTypeId, [IE::OUTPUT_CARD_CARD, IE::OUTPUT_CARD_CASH, IE::OUTPUT_WALLET_CARD, IE::OUTPUT_WALLET_WALLET, IE::OUTPUT_EXCHANGE] ) ) {
            $listBoxIncome =  Box::on()->orderBy('unique_name')->get();
            $listBoxExpense = Box::on()->orderBy('unique_name')->get();
        }
    }

    /**
     * Определяет является открываемый приход/расход выводом средств.
     * Вывод средств это парная заявка.
     * Истина - парная заявка.
     * Ложь - одиночная заявка.
     *
     * @param int $incomeExpenseTypeId
     * @return bool
     */
    private function isOutput( int $incomeExpenseTypeId ) : bool
    {
        $output = [
            IE::OUTPUT_CARD_CARD,
            IE::OUTPUT_CARD_CASH,
            IE::OUTPUT_WALLET_CARD,
            IE::OUTPUT_WALLET_WALLET,
            IE::OUTPUT_EXCHANGE ,
        ];

        return ( in_array( $incomeExpenseTypeId, $output ) ) ? true : false;
    }

    /**
     * При открытии прихода/расхода заполняет поля для формы.
     *
     * @param $incomeExpenseModel
     * @param $incomeId
     * @param $boxIncomeId
     * @param $amountIncome
     * @param $rateIncome
     * @param $expenseId
     * @param $boxExpenseId
     * @param $amountExpense
     * @param $rateExpense
     */
    public function getFieldOutput(
        $incomeExpenseModel,
        &$incomeId,
        &$boxIncomeId,
        &$amountIncome,
        &$rateIncome,
        &$expenseId,
        &$boxExpenseId,
        &$amountExpense,
        &$rateExpense
    ) : void
    {
        // Если заявка не парная то мы поля не заполняем.
        if ( ! $this->isOutput( $incomeExpenseModel->income_expense_type_id ) ) {
            return;
        }

        if ( $incomeExpenseModel->income_expense === 'income' ) {
            $modelIncome = $incomeExpenseModel;
            $modelExpense = IncomeExpense::on()->where('id', $incomeExpenseModel->expense_id)->first();
        } else {
            $modelIncome = IncomeExpense::on()->where('expense_id', $incomeExpenseModel->id)->first();
            $modelExpense = $incomeExpenseModel;
        }

        $incomeId = $modelIncome->id;
        $boxIncomeId = $modelIncome->box_id;
        $amountIncome = $modelIncome->amount;
        $rateIncome = $modelIncome->rate;
        $expenseId = $modelExpense->id;
        $boxExpenseId = $modelExpense->box_id;
        $amountExpense = $modelExpense->amount;
        $rateExpense = $modelExpense->rate;
    }

    /**
     * Требуется комментарий.
     *
     * @param int $incomeExpenseTypeId
     * @return bool
     */
    public function isCommentRequired( int $incomeExpenseTypeId )
    {
        $listTypeForCommentRequired = [
            // Приход незавершенка
            IE::INCOME_UNFINISHED,
            // Расход незавершенка
            IE::EXPENSE_UNFINISHED,
            // Расход фирмы
            IE::COMPANY_EXPENSE,
            // Приход фирмы
            IE::COMPANY_INCOME,
        ];

        return ( in_array( $incomeExpenseTypeId, $listTypeForCommentRequired ) ) ? true : false;
    }
}
