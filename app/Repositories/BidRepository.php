<?php

namespace App\Repositories;

use App\Models\Bid;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BidRepository extends Repositories implements BidRepositoryInterface
{
    /**
     * @var Bid
     */
    protected $model;

    /**
     * OfferRepository constructor.
     *
     * @param Bid $model
     */
    public function __construct(Bid $model)
    {
        parent::__construct($model);
    }

    /**
     * Возвращает список заявок.
     * Если указана "Дата С" и "Дата По" то возвращает заявки за этот интервал.
     * Если указано направление по которому получаем или отдаем то фильтруем и по нему.
     *
     * @return Collection
     */
    public function getListBid(): Collection
    {
        return DB::table('bid as b')
            ->select(DB::raw(
                'b.id as id,
                b.bid_number as bid_number,
                d.descr as top_destinations_descr,
                CONCAT(ps_get.descr, " ", c_get.descr) as direction_get_descr,
                (
                    SELECT TRIM(SUM(o_get.amount)) + 0
                    FROM offer as o_get
                    WHERE o_get.enum_inc_exp = "inc" and o_get.bid_id = b.id
                ) as total_amount_get,
                CONCAT(ps_give.descr, " ", c_give.descr) as direction_give_descr,
                (
                    SELECT TRIM(SUM(o_give.amount)) + 0
                    FROM offer as o_give
                    WHERE o_give.enum_inc_exp = "exp" and o_give.bid_id = b.id
                ) as total_amount_give,
                b.note as note,
                b.updated_at as updated_at,
                concat(cu.surname, " ", LEFT(cu.name, 1), ". ", LEFT(cu.patronymic, 1), ".") as created_full_name,
                concat(mu.surname, " ", LEFT(mu.name, 1), ". ", LEFT(mu.patronymic, 1), ".") as manager_full_name
                '
            ))
            ->leftJoin('top_destinations as d', 'b.top_destinations_id', '=', 'd.id')
            // Мы получаем
            ->leftJoin('direction as d_get', 'b.direction_get_id', '=', 'd_get.id')
            ->leftJoin('payment_system as ps_get', 'd_get.payment_system_id', '=', 'ps_get.id')
            ->leftJoin('currency as c_get', 'd_get.currency_id', '=', 'c_get.id')
            // Мы отдаем
            ->leftJoin('direction as d_give', 'b.direction_give_id', '=', 'd_give.id')
            ->leftJoin('payment_system as ps_give', 'd_give.payment_system_id', '=', 'ps_give.id')
            ->leftJoin('currency as c_give', 'd_give.currency_id', '=', 'c_give.id')
            // Кто создал и кто менеджер
            ->leftJoin('users as cu', 'b.created_user_id', '=', 'cu.id')
            ->leftJoin('users as mu', 'b.manager_user_id', '=', 'mu.id')
            ->when( ! is_null( session('bid_filter_start_date') ), function ($query) {
                return $query->where('b.updated_at', '>=', session('bid_filter_start_date') . ' 00:00:00');
            })
            ->when( ! is_null( session('bid_filter_stop_date') ), function ($query) {
                return $query->where('b.updated_at', '<=', session('bid_filter_stop_date') . ' 23:59:59');
            })
            ->when( is_numeric( session('bid_filter_direction_get_id', 'not numeric') ), function ($query) {
                return $query->where('b.direction_get_id', session('bid_filter_direction_get_id'));
            })
            ->when( is_numeric( session('bid_filter_direction_give_id', 'not numeric') ), function ($query) {
                return $query->where('b.direction_give_id', session('bid_filter_direction_give_id'));
            })
            ->when( ! is_null( session('bid_filter_bid_number') ), function ($query) {
                return $query->where('b.bid_number', '=', session('bid_filter_bid_number'));
            })
            ->orderByDesc('b.id')
            ->get();
    }
}
