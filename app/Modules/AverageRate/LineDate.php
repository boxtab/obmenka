<?php

namespace App\Modules\AverageRate;

use App\Models\Bid;
use App\Models\BoxBalance;
use App\Models\IncomeExpense;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;

/**
 * Начало периода.
 * Конец периода.
 * Период. Массив дат с начало периода и до конца.
 *
 * @package App\Modules\AverageRate
 */
class LineDate
{
    /**
     * @var string Дата начала периода.
     */
    private $startDate;

    /**
     * @var string Дата окончания периода.
     */
    private $stopDate;

    /**
     * @var array Период.
     */
    private $period = [];

    /**
     * Заполняет:
     *  Дату начала периода.
     *  Дату окончания периода.
     *  Период.
     *
     * LineDate constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $dateOperation = [];
        // Извлекаем минимальные даты из таблиц: Заявки, Балансы боксов, приход/расход.
        $dateOperation[] = Carbon::parse( Bid::on()->min('updated_at') )->format('Y-m-d');
        $dateOperation[] = BoxBalance::on()->min('balance_date');
        $dateOperation[] = Carbon::parse( IncomeExpense::on()->min('updated_at') )->format('Y-m-d');
        // Берем минимальную дату из трех минимальных.
        $this->startDate = min( $dateOperation );

        // Дата окончания это текущий день.
        $this->stopDate = Carbon::now()->format('Y-m-d');

        // Период. Массив дат с первой по текущий день.
        $datePeriod = new DatePeriod(
            new DateTime( $this->startDate ),
            new DateInterval('P1D'),
            new DateTime( Carbon::tomorrow()->format('Y-m-d') )
        );

        foreach ( $datePeriod as $key => $value ) {
            $this->period[] = $value->format('Y-m-d');
        }
    }

    /**
     * Возвращает дату начала периода.
     *
     * @return string
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Возвращает дату окончания периода.
     *
     * @return string
     */
    public function getStopDate()
    {
        return $this->stopDate;
    }

    /**
     * Возвращает период.
     *
     * @return array
     */
    public function getPeriod()
    {
        return $this->period;
    }

}
