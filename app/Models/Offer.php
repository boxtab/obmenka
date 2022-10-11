<?php

namespace App\Models;

use App\Models\Books\Box;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends BaseModel
{
    protected $table = 'offer';

    protected $fillable = [
        'bid_id',
        'enum_inc_exp',
        'box_id',
        'amount',
        'created_at',
        'updated_at',
        'created_user_id',
        'updated_user_id',
    ];

    public function bid(): BelongsTo
    {
        return $this->belongsTo(Bid::class, 'bid_id', 'id')
            ->withDefault();
    }

    public function box(): BelongsTo
    {
        return $this->belongsTo(Box::class, 'box_id', 'id')
            ->withDefault();
    }

    /**
     * Приход или расход на русском.
     *
     * @return string
     */
    public function getIncExpAttribute(): string
    {
        return $this->enum_inc_exp === 'inc' ? 'Приход' : 'Расход';
    }
}
