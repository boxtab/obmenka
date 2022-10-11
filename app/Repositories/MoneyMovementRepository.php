<?php

namespace App\Repositories;

use App\Models\Bid;
use App\Models\Offer;
use App\Models\IncomeExpense;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MoneyMovementRepository extends Repositories implements MoneyMovementRepositoryInterface
{
    /**
     * @var IncomeExpense
     */
    private $incomeExpense;

    /**
     * MoneyMovementRepository constructor.
     *
     * @param Offer $offer
     */
    public function __construct( Offer $offer )
    {
        parent::__construct( $offer );

        $incomeExpense = new IncomeExpense();
    }

    /**
     * Для определенного бокса на определенный день
     * возвращает список движения денег взятый из заявок и прихода/расхода.
     *
     * @param int $boxId
     * @param string $date
     * @return Collection
     */
    public function getListDayByBox( int $boxId, string $date ): Collection
    {
        $from = $date . ' 00:00:00';
        $to = $date . ' 23:59:59';

        $listOffer = DB::table('offer as o')
            ->select(DB::raw('
                o.id as id,
                o.bid_id as bid_id,
                IF(o.enum_inc_exp = "inc", "Приход", "Расход") as inc_exp,
                trim(o.amount) + 0 as amount,
                o.created_at as created_at,
                o.updated_at as updated_at,
                CONCAT(cu.surname, " ", LEFT(cu.name, 1), ". ", LEFT(cu.patronymic, 1), ".") as created_full_name,
                CONCAT(uu.surname, " ", LEFT(uu.name, 1), ". ", LEFT(uu.patronymic, 1), ".") as updated_full_name
            '))
            ->leftJoin('users as cu', 'o.created_user_id', '=', 'cu.id')
            ->leftJoin('users as uu', 'o.updated_user_id', '=', 'uu.id')
//            ->leftJoin('bid as b', 'o.bid_id', '=', 'b.id')
            ->where('o.box_id', $boxId)
            ->whereBetween('o.updated_at', [$from, $to]);
//            ->whereBetween('b.updated_at', [$from, $to]);

        return DB::table('income_expense as ie')
            ->select(DB::raw('
                ie.id as id,
                null as bid_id,
                IF(ie.income_expense = "income", "Приход", "Расход") as inc_exp,
                trim(ie.amount) + 0 as amount,
                ie.created_at as created_at,
                ie.updated_at as updated_at,
                CONCAT(cu.surname, " ", LEFT(cu.name, 1), ". ", LEFT(cu.patronymic, 1), ".") as created_full_name,
                CONCAT(uu.surname, " ", LEFT(uu.name, 1), ". ", LEFT(uu.patronymic, 1), ".") as updated_full_name
            '))
            ->leftJoin('users as cu', 'ie.created_user_id', '=', 'cu.id')
            ->leftJoin('users as uu', 'ie.updated_user_id', '=', 'uu.id')
            ->where('ie.box_id', $boxId)
            ->whereBetween('ie.updated_at', [$from, $to])
            ->union($listOffer)
            ->orderByDesc('id')
            ->get();
    }
}
