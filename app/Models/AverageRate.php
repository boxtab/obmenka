<?php

namespace App\Models;

use App\Models\Books\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AverageRate extends BaseModel
{
//    use HasFactory;

    protected $table = 'average_rate';

    protected $fillable = [
        'rate_date',
        'currency_id',
        'rate',
        'created_at',
        'updated_at',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
    ];

    protected $casts = [
        'rate_date' => 'date:Y-m-d',
        'currency_id' => 'integer',
        'rate' => 'decimal:8',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_user_id' => 'integer',
        'updated_user_id' => 'integer',
        'deleted_user_id' => 'integer',
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id')
            ->withDefault();
    }
}
