<?php

namespace App\Repositories;

use App\Models\Books\Currency;
use App\Models\Constants\CurrencyConstant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CurrencyRepository extends Repositories implements CurrencyRepositoryInterface
{
    /**
     * @var Currency
     */
    protected $model;

    /**
     * CurrencyRepository constructor.
     *
     * @param Currency $model
     */
    public function __construct( Currency $model )
    {
        parent::__construct( $model );
    }

    /**
     * Список валют с балансами и средними курсами.
     *
     * @return array
     */
    public function getList(): array //: Collection
    {
        return DB::table('currency as c')
            ->select(DB::raw("
                c.id as id,
                c.descr as descr,
                c.balance as balance,
                TRIM(c.rate) + 0 as rate,
                c.balance * c.rate as balance_ruble
            "))
            ->orderBy('c.id' , 'ASC')
            ->get()
            ->map( function ( $item ) {
                return (array)$item;
            })
            ->toArray();
    }

    /**
     * Обновит одно поле в справочнике валют.
     *
     * @param int $id
     * @param string $fieldName
     * @param $fieldValue
     */
    public function updateField( int $id, string $fieldName, $fieldValue )
    {
        $this->model->on()
            ->where('id', $id)
            ->update([$fieldName => $fieldValue]);
    }

    /**
     * По id возвращает остаток валюты в рубле.
     *
     * @param int $id
     * @return float
     */
    public function getBalanceRub( int $id )
    {
        return floatval( $this->model->on()
            ->select( DB::raw('balance * rate as balance_rub') )
            ->where('id', '=', $id)
            ->first()->balance_rub );
    }
}
