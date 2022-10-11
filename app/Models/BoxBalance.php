<?php

namespace App\Models;

use App\Models\Books\Box;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class BoxBalance extends BaseModel
{
    protected $table = 'box_balance';

    protected $fillable = [
        'balance_date',
        'box_id',
        'balance_amount',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
    ];

    protected $casts = [
        'balance_date'      => 'datetime:Y-m-d',
        'box_id'            => 'integer',
        'balance_amount'    => 'decimal:8',
        'created_at'        => 'datetime:Y-m-d h:i:s',
        'updated_at'        => 'datetime:Y-m-d h:i:s',
        'deleted_at'        => 'datetime:Y-m-d h:i:s',
        'created_user_id'   => 'integer',
        'updated_user_id'   => 'integer',
        'deleted_user_id'   => 'integer',
    ];

    protected $appends = [
        'calculated_balance',
        'difference',
        'created_full_name',
        'updated_full_name',
    ];

    public function box(): BelongsTo
    {
        return $this->belongsTo(Box::class, 'box_id', 'id')
            ->withDefault();
    }

    /**
     * Предыдущий баланс текущего бокса если он есть иначе ноль.
     *
     * @return float
     */
    private function getPreviousBalance(): float
    {
        // Ищем предыдущую дату.
        $previousDate = BoxBalance::on()
            ->where('box_id', $this->box_id)
            ->whereDate('balance_date', '<', $this->balance_date->format('Y-m-d'))
            ->max('balance_date');


        if ( ! is_null( $previousDate ) ) {
            // Если дата существует то извлекаем предыдущий остаток.
            $previousBalance = BoxBalance::on()
                ->where('box_id', $this->box_id)
                ->whereDate('balance_date', $previousDate)
                ->pluck('balance_amount')
                ->first();
        } else {
            // Если дата пустая то извлекаем начальный остаток бокса.
            $previousBalance = Box::on()
                ->where('id', $this->box_id)
                ->pluck('balance')
                ->first();
        }

        return numberFormat8( $previousBalance );
    }

    /**
     * Рассчетный остаток.
     *
     * @return float
     */
    public function getCalculatedBalanceAttribute() : float
    {
        $previousBalance = $this->getPreviousBalance();

        $from = $this->balance_date->format('Y-m-d') . ' 00:00:00';
        $to = $this->balance_date->format('Y-m-d') . ' 23:59:59';

        $incomeBid = numberFormat8(
            Offer::on()
            ->where('enum_inc_exp', 'inc')
            ->where('box_id', $this->box_id)
            ->whereBetween('updated_at', [$from, $to])
            ->sum('amount')
        );

        $incomeIE = numberFormat8(
            IncomeExpense::on()
            ->where('income_expense', 'income')
            ->where('box_id', $this->box_id)
            ->whereBetween('updated_at', [$from, $to])
            ->sum('amount')
        );

        $expenseBid = numberFormat8(
            Offer::on()
            ->where('enum_inc_exp', 'exp')
            ->where('box_id', $this->box_id)
            ->whereBetween('updated_at', [$from, $to])
            ->sum('amount')
        );

        $expenseIE = numberFormat8(
            IncomeExpense::on()
            ->where('income_expense', 'expense')
            ->where('box_id', $this->box_id)
            ->whereBetween('updated_at', [$from, $to])
            ->sum('amount')
        );

        return numberFormat8( $previousBalance + $incomeBid + $incomeIE - $expenseBid - $expenseIE );
    }

    /**
     * Разница между остатками.
     * Реальный остаток минус расчетный остаток.
     * Если ноль то карта сведена правильно.
     * Иначе оператору нужно искать ошибку.
     *
     * @return float
     */
    public function getDifferenceAttribute()
    {
        $balanceAmount = numberFormat8( $this->balance_amount );
        $calculatedBalance = numberFormat8( $this->calculated_balance );

        $difference = $balanceAmount - $calculatedBalance;

        return number_format( $difference, 8, ',', ' ' );
    }
}
