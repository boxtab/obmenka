<?php

namespace App\Models\Constants;

class IncomeExpenseTypeNameConstant
{
    /**
     * @var string Партнеры
     */
    const PARTNERS = 'Партнеры';

    /**
     * @var string Приход незавершенка
     */
    const INCOME_UNFINISHED = 'Приход незавершенка';

    /**
     * @var string Расход незавершенка
     */
    const EXPENSE_UNFINISHED = 'Расход незавершенка';

    /**
     * @var string Расход фирмы
     */
    const COMPANY_EXPENSE = 'Расход фирмы';

    /**
     * @var string Приход фирмы
     */
    const COMPANY_INCOME = 'Приход фирмы';

    /*
     * Выводы с бокса на бокс.
     */

    /**
     * @var string Вывод карта/карта
     */
    const OUTPUT_CARD_CARD = 'Вывод карта/карта';

    /**
     * @var string Вывод карта/нал
     */
    const OUTPUT_CARD_CASH = 'Вывод карта/нал';

    /**
     * @var string Вывод кошелек/карта
     */
    const OUTPUT_WALLET_CARD = 'Вывод кошелек/карта';

    /**
     * @var string Вывод кошелек/кошелек
     */
    const OUTPUT_WALLET_WALLET = 'Вывод кошелек/кошелек';

    /**
     * @var string Вывод обмен (разные валюты)
     */
    const OUTPUT_EXCHANGE = 'Вывод обмен (разные валюты)';

}
