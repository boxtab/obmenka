<?php

namespace App\Helpers;

use App\Models\Constants\IncomeExpenseTypeConstant;

class IncomeExpenseHelper
{
    /**
     * По id константы возвращает имя шаблона для его подключения.
     *
     * @param int $typeOperationId
     * @return string
     */
    public static function getOperationTemplateById( int $typeOperationId )
    {
        $nameTemplate = '';

        switch ( $typeOperationId ) {
            case IncomeExpenseTypeConstant::PARTNERS :
                // Партнеры
                $nameTemplate = 'partners';
                break;
            case IncomeExpenseTypeConstant::INCOME_UNFINISHED :
                // Приход незавершенка
                $nameTemplate = 'unfinished';
                break;
            case IncomeExpenseTypeConstant::EXPENSE_UNFINISHED :
                // Расход незавершенка
                $nameTemplate = 'unfinished';
                break;
            case IncomeExpenseTypeConstant::COMPANY_EXPENSE :
                // Расход фирмы
                $nameTemplate = 'firm';
                break;
            case IncomeExpenseTypeConstant::COMPANY_INCOME :
                // Приход фирмы
                $nameTemplate = 'firm';
                break;
            case IncomeExpenseTypeConstant::OUTPUT_CARD_CARD :
                // Вывод карта/карта
                $nameTemplate = 'output';
                break;
            case IncomeExpenseTypeConstant::OUTPUT_CARD_CASH :
                // Вывод карта/нал
                $nameTemplate = 'output';
                break;
            case IncomeExpenseTypeConstant::OUTPUT_WALLET_CARD :
                // Вывод кошелек/карта
                $nameTemplate = 'output';
                break;
            case IncomeExpenseTypeConstant::OUTPUT_WALLET_WALLET :
                // Вывод кошелек/кошелек
                $nameTemplate = 'output';
                break;
            case IncomeExpenseTypeConstant::OUTPUT_EXCHANGE :
                // Вывод обмен (разные валюты)
                $nameTemplate = 'output';
                break;
        }

        return $nameTemplate;
    }

    /**
     * По id типа операции прихода/расхода возвращает описание типа операции на русском.
     *
     * @param int $typeOperationId
     * @return mixed
     */
    public static function getOperationDescrById( int $typeOperationId )
    {
        $arrayTypeIncomeExpense = constantsInClassToArray( '\\App\Models\Constants\IncomeExpenseTypeNameConstant' );
        return array_values( $arrayTypeIncomeExpense )[$typeOperationId - 1];
    }
}
