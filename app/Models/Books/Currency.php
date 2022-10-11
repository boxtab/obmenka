<?php

namespace App\Models\Books;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Currency extends BaseModel
{
    protected $table = 'currency';

    protected $fillable = [
        'descr',
        'balance',
        'rate',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
    ];

//    protected $casts = [
//        'descr' => 'string:16',
//        'balance' => 'decimal:18:8',
//        'rate' => 'decimal:18:8',
//        'created_at' => 'datetime',
//        'updated_at' => 'datetime',
//        'deleted_at' => 'datetime',
//        'created_user_id' => 'integer',
//        'updated_user_id' => 'integer',
//        'deleted_user_id' => 'integer',
//    ];


    /**
     * Баланс в рубле.
     *
     * @return float|int
     */
    public function getBalanceRubleAttribute()
    {
        return $this->balance * $this->rate;
    }
}
