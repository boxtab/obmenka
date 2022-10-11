<?php

if ( ! function_exists('numberFormat') ) {
    /**
     * 1. Убирает конечные нули
     * Преобразовывая число сначало в строку, а потом в вещественный тип.
     * https://stackoverflow.com/questions/5149129/how-to-strip-trailing-zeros-in-php
     *
     * 2. Удалите букву «E» в числовом формате для очень маленьких чисел.
     * Использует дя этого number_format
     * https://stackoverflow.com/questions/29442217/remove-the-e-in-a-number-format-for-very-small-numbers
     *
     * @param $rowNumber
     * @param int $decimals
     * @return float
     */
    function numberFormat( $rowNumber, int $decimals ): float
    {
        $stringNumber = (string) $rowNumber;
        $floatNumber = (float) $stringNumber;
        $numberFormat = number_format( $floatNumber, $decimals, '.', '' );
        return (float) $numberFormat;
    }
}

if ( ! function_exists('numberFormat8') ) {
    /**
     * Количество знаков после десятичной точки не больше 8.
     *
     * @param $rowNumber
     * @return float
     */
    function numberFormat8( $rowNumber )
    {
        return numberFormat( $rowNumber, 8 );
    }
}

if ( ! function_exists('numberFormat12') ) {
    /**
     * Количество знаков после десятичной точки не больше 12.
     *
     * @param $rowNumber
     * @return float
     */
    function numberFormat12( $rowNumber )
    {
        return numberFormat( $rowNumber, 12 );
    }
}
