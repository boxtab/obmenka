<?php

namespace App\Repositories;

use App\Models\AverageRate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AverageRateRepository extends Repositories implements AverageRateRepositoryInterface
{
    /**
     * @var integer Количество последних дней.
     */
    const NUMBER_LAST_DAYS = 7;

    /**
     * @var AverageRate
     */
    protected $model;

    /**
     * AverageRateRepository constructor.
     *
     * @param AverageRate $model
     */
    public function __construct(AverageRate $model)
    {
        parent::__construct($model);
    }

    /**
     * Сводная таблица средних курсов.
     *
     * @param array $listLastDays
     * @return Collection
     */
    public function getPivot( array $listLastDays ): Collection
    {
        $listField = '';
        foreach ( $listLastDays as $day ) {
            $listField .= ", sum(case when ar.rate_date = '$day' then ar.rate else 0 end) as " . getDateToCamelCase( $day );
        }

        return DB::table('average_rate as ar')
            ->select(DB::raw("
                c.descr as currency_descr
                $listField
            "))
            ->leftJoin('currency as c', 'ar.currency_id', '=', 'c.id')
            ->groupBy('c.descr')
            ->orderBy('c.descr')
            ->get();
    }

    /**
     * Возвращает список 7 последних дат на которые были установлены курсы валют.
     *
     * @return array
     */
    public function getLastDays(): array
    {
        $days = $this->model->on()
            ->groupBy('rate_date')
            ->orderByDesc('rate_date')
            ->limit( self::NUMBER_LAST_DAYS )
            ->get('rate_date')
            ->pluck('rate_date')
            ->toArray();

        return getDaysWithoutTime( $days );
    }

    /**
     * Получает массив дат, возвращает эти же даты преобразованны в имена полей.
     *
     * @param array $listLastDays
     * @return array
     */
    public function getFieldNameLastDays( array $listLastDays ): array
    {
        $fieldNameLastDays = [];
        foreach ( $listLastDays as $day ) {
            $fieldNameLastDays[] = getDateToCamelCase( $day );
        }
        return $fieldNameLastDays;
    }

    /**
     * Очистка таблицы средних курсов.
     */
    public function clear()
    {
        $this->model->on()->truncate();
    }
}
