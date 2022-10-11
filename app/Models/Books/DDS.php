<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;

/**
 * ДДС.
 * Движение денежных средств.
 *
 * @package App\Models\Books
 */
class DDS extends BaseModel
{
    protected $table = 'dds';

    protected $fillable = [
        'descr',
        'top_destinations_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
    ];

    public function topDestinations(): BelongsTo
    {
        return $this->belongsTo(TopDestinations::class, 'top_destinations_id', 'id')
            ->withDefault();
    }
}
