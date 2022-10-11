<?php

namespace App\Models\Books;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

/**
 * Группы источников дохода.
 *
 * @package App\Models\Books
 */
class TopDestinationsGroup extends BaseModel
{
    protected $table = 'top_destinations_group';

    protected $fillable = [
        'description',
        'month_year',
    ];

    public function getMonthYearFormatAttribute(): string
    {
        return Carbon::parse( $this->month_year )->format('Y-m');
    }
}
