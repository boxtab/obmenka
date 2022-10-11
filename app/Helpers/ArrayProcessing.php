<?php

if ( ! function_exists('constantsInClassToArray') ) {
    /**
     * Получает имя класса с полным путем к нему и возвращает ассоциативный массив состоящий из констант класса.
     * Где ключ массива это имя константы, а значение эелемнта массива это значение константы.
     *
     * @param string $pathNameClass
     * Строка: \\App\Models\Constants\IncomeExpenseTypeConstant
     *
     * @return array
     * Массив:
     * array:4 [▼
     *      "PARTNERS" => 1
     *      "INCOME_UNFINISHED" => 2
     *      "EXPENSE_UNFINISHED" => 3
     *      "COMPANY_EXPENSE" => 4
     * ]
     */
    function constantsInClassToArray( string $pathNameClass ): array
    {
        try {
            $reflection = new ReflectionClass( $pathNameClass );
            return (array) $reflection->getConstants();
        } catch ( Exception $e ) {
            return [];
        }
    }
}
