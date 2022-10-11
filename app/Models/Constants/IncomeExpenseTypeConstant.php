<?php

namespace App\Models\Constants;

use Illuminate\Database\Eloquent\Model;

/**
 * Class IncomeExpenseTypeConstant
 * @package App\Models\Constants
 */
class IncomeExpenseTypeConstant
{
    /*
     * Партнеры
     * Приход незавершенка
     * Расход незавершенка
     * Расход фирмы
     * Приход фирмы
     *
     * Вывод карта/карта
     * Вывод карта/нал
     * Вывод кошелек/карта
     * Вывод кошелек/кошелек
     * Вывод обмен (разные валюты)
     */

    /**
     * @var integer Партнеры
     */
    const PARTNERS = 1;

    /**
     * @var integer Приход незавершенка
     */
    const INCOME_UNFINISHED = 2;

    /**
     * @var integer Расход незавершенка
     */
    const EXPENSE_UNFINISHED = 3;

    /**
     * @var integer Расход фирмы
     */
    const COMPANY_EXPENSE = 4;

    /**
     * @var integer Приход фирмы
     */
    const COMPANY_INCOME = 5;

    /*
     * Выводы с бокса на бокс.
     */

    /**
     * @var integer Вывод карта/карта
     */
    const OUTPUT_CARD_CARD = 6;

    /**
     * @var integer Вывод карта/нал
     */
    const OUTPUT_CARD_CASH = 7;

    /**
     * @var integer Вывод кошелек/карта
     */
    const OUTPUT_WALLET_CARD = 8;

    /**
     * @var integer Вывод кошелек/кошелек
     */
    const OUTPUT_WALLET_WALLET = 9;

    /**
     * @var integer Вывод обмен (разные валюты)
     */
    const OUTPUT_EXCHANGE = 10;
}
