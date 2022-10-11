<?php

if ( ! function_exists('getDateToCamelCase') ) {
    /**
     * Преобразовывает дату из американского формата в формат идентификатора
     * который можно использовать в качестве имени переменной.
     *
     * @param string $rowDate
     * Строка: 2021-04-19
     *
     * @return string
     * Строка: d2021_04_19
     *
     * */
    function getDateToCamelCase( string $rowDate ): string
    {
        return 'd_' . str_replace('-', '_', $rowDate);
    }
}
