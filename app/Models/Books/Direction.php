<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\BaseModel;

class Direction extends BaseModel
{
    protected $table = 'direction';

    protected $fillable = [
        'payment_system_id',
        'currency_id',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
    ];

    public function paymentSystem(): BelongsTo
    {
        return $this->belongsTo(PaymentSystem::class, 'payment_system_id', 'id')
            ->withDefault();
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id')
            ->withDefault();
    }

    // TODO: Разобраться зачем это нужно?
    public function sorted()
    {
        return $this->join('payment_system', 'payment_system.id', '=', 'direction.payment_system_id')
            ->orderBy('payment_system.descr', 'ASC')
            ->join('currency', 'currency.id', '=', 'direction.currency_id')
            ->orderBy('currency.descr', 'ASC')
            ->select('direction.*')
            ->get();
    }
}
