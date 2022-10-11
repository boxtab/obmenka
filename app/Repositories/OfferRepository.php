<?php

namespace App\Repositories;

use App\Models\Offer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OfferRepository extends Repositories implements OfferRepositoryInterface
{
    /**
     * @var Offer
     */
    protected $model;

    /**
     * OfferRepository constructor.
     *
     * @param Offer $model
     */
    public function __construct( Offer $model )
    {
        parent::__construct( $model );
    }

    /**
     * Список платежей которые поступают для заявки.
     *
     * @param int $bidId
     * @return Collection
     */
    public function getListGet( int $bidId ): Collection
    {
        return Offer::on()
            ->where('bid_id', $bidId)
            ->where('enum_inc_exp', 'inc')
            ->get();
    }

    /**
     * Список платежей которые мы получаем по заявки.
     *
     * @param int $bidId
     * @return Collection
     */
    public function getListGive( int $bidId ): Collection
    {
        return Offer::on()
            ->where('bid_id', $bidId)
            ->where('enum_inc_exp', 'exp')
            ->get();
    }

    public function getListExport(?string $startDate = null, ?string $stopDate = null): Collection
    {
        return DB::table('offer')
            ->select(DB::raw('
                offer.id as offer_id,
                bid.bid_number as bid_number,
                td.descr as top_destinations_descr,
                offer.updated_at as updated_at,
                b.unique_name as box_name,
                offer.enum_inc_exp as ie,
                offer.amount as amount
            '))
            ->leftJoin('bid', 'offer.bid_id', '=', 'bid.id')
            ->leftJoin('top_destinations as td', 'bid.top_destinations_id', '=', 'td.id')
            ->leftJoin('box as b', 'offer.box_id', '=', 'b.id')
            ->when( ! is_null($startDate), function ($query) use ($startDate) {
                return $query->where('offer.updated_at', '>=', $startDate . ' 00:00:00');
            })
            ->when( ! is_null($stopDate), function ($query) use ($stopDate) {
                return $query->where('offer.updated_at', '<=', $stopDate . ' 23:59:59');
            })
            //->skip(0)->take(10)
            //->orderBy('offer.id', 'desc')
            //->where('bid_number', '=', '405')
            ->orderBy('offer.id', 'asc')
            ->get();
    }
}
