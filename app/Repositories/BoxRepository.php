<?php

namespace App\Repositories;

use App\Models\Books\Box;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BoxRepository extends Repositories implements BoxRepositoryInterface
{
    /**
     * BoxRepository constructor.
     *
     * @param Box $box
     */
    public function __construct(Box $box)
    {
        parent::__construct($box);
    }

    /**
     * Возвращает весь список боксов, а если передано направление то фильтрует по направлениям.
     *
     * @param int|null $directionId
     * @return Collection
     */
    public function getListBox( ?int $directionId ): Collection
    {
        if ( ! is_null( $directionId ) ) {
            $listBox = $this->model->on()->where('direction_id', $directionId)->get();
        } else {
            $listBox = $this->model->on()->orderBy('unique_name')->get();
        }

        return $listBox;
    }

    /**
     * Возвращает начальные остатки боксов.
     *
     * @return array
     */
    public function getListBalanceBox(): array
    {
        return DB::table('box as b')
            ->select(DB::raw("
                b.id as id,
                IF( b.type_box = 'card', 'Карта', 'Кошелек' ) as type_box_descr,
                b.unique_name as unique_name,
                TRIM(b.balance) + 0 as balance
            "))
            ->orderBy('b.id' , 'ASC')
            ->get()
            ->map( function ( $item ) {
                return (array)$item;
            })
            ->toArray();
    }

    /**
     * Обновляет баланс первоночального остатка бокса.
     *
     * @param int $id
     * @param float $balance
     */
    public function pushBalance( int $id, float $balance )
    {
        $this->model->on()
            ->where('id', $id)
            ->update( ['balance' => $balance] );
    }

    /**
     * Возвращает начальный баланс бокса по id.
     *
     * @param int $id
     * @return float
     */
    public function pullBalance( int $id ): float
    {
        return floatval(
            $this->model->on()
                ->where('id', '=', $id)
                ->pluck('balance')->first()
        );
    }
}
