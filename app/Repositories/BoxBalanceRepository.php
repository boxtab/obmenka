<?php

namespace App\Repositories;

use App\Http\Requests\DuplicateBoxBalance;
use App\Models\BoxBalance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

/**
 * Class BoxBalanceRepository
 * @package App\Repositories
 */
class BoxBalanceRepository extends Repositories implements BoxBalanceRepositoryInterface
{
    /**
     * @var BoxBalance
     */
    protected $model;

    /**
     * BoxBalanceRepository constructor.
     *
     * @param BoxBalance $model
     */
    public function __construct( BoxBalance $model )
    {
        parent::__construct( $model );
    }

    /**
     * Обновления остатка по id.
     *
     * @param int $id
     * @param float $amount
     */
    public function updateAmountById( int $id, float $amount )
    {
        $this->model->on()
            ->where('id', $id)
            ->update(['balance_amount' => $amount]);
    }

    /**
     * Возвращает строку по id.
     *
     * @param int $id
     * @return BoxBalance
     */
    public function getRowById( int $id ): BoxBalance
    {
        return $this->model->on()->where( 'id', $id )->get()[0];

    }

    /**
     * Список остатков по боксам пропущенных через фильтр.
     *
     * @return Collection
     */
    public function getList(): Collection
    {
        return BoxBalance::on()
            ->when( session()->exists('box-balance_filter_date'), function ( $query ) {
                return $query->where( 'balance_date', session('box-balance_filter_date') );
            } )
            ->orderByDesc('id')
            ->get();
    }

    /**
     * Дублирует остатки.
     *  session( 'box-balance_filter_date' ) - дата с которой делаем копию.
     *  $request->donor_date - дата копии.
     *  Сначало зачищаем старые остатки. И создаем новые.
     *
     * @param DuplicateBoxBalance $request
     */
    public function duplicate( DuplicateBoxBalance $request )
    {
        DB::transaction( function () use ( $request ) {
            $listParentIds = BoxBalance::on()
                ->where('balance_date', $request->session()->get( 'box-balance_filter_date' ))
                ->get()
                ->pluck('id')
                ->toArray();

            BoxBalance::on()->where('balance_date', $request->donor_date)->delete();

            foreach ( $listParentIds as $parentId ) {
                $childDay = BoxBalance::on()->find( $parentId )->replicate();
                $childDay->balance_date = $request->donor_date;
                $childDay->updated_user_id = null;
                $childDay->save();
            }
        });

        Session::put('box-balance_filter_date', $request->donor_date);
    }


    public function getListExport(?string $date) : Collection
    {
        return BoxBalance::on()
            ->where( 'balance_date', $date )
            ->orderByDesc('id')
            ->get();
    }
}
