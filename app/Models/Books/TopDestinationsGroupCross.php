<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\BaseModel;

/**
 * Кросс таблица между источниками дохода и их группами.
 *
 * @package App\Models\Books
 */
class TopDestinationsGroupCross extends Model
{
    use HasFactory;

    protected $table = 'top_destinations_group_cross';

    protected $fillable = [
        'top_destinations_id',
        'top_destinations_group_id',
    ];

    public function topDestinations(): BelongsTo
    {
        return $this->belongsTo(TopDestinations::class, 'top_destinations_id', 'id')
            ->withDefault();
    }

    public function topDestinationsGroup(): BelongsTo
    {
        return $this->belongsTo(TopDestinationsGroup::class, 'top_destinations_group_id', 'id')
            ->withDefault();
    }
}
