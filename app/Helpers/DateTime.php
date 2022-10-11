<?php

use Carbon\Carbon;

if ( ! function_exists('getDaysWithoutTime') ) {
    /**
     * Получает массив строк. Каждый элемент это дата и время.
     * Возвращает этот же массив с датами но без времени.
     *
     * @param array $daysTime
     * Массив дат с временем в текстовом виде.
     *
     * @return array усеченные даты, без времени.
     *
     * */
    function getDaysWithoutTime( array $daysTime ): array
    {
        $daysWithoutTime = [];
        foreach ( $daysTime as $dayTime ) {
            $daysWithoutTime[] = Carbon::parse( $dayTime )->format('Y-m-d');
        }
        return $daysWithoutTime;
    }
}
