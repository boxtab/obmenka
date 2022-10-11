<?php

namespace App\Models\Books;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Источники дохода.
 *
 * @package App\Models\Books
 */
class TopDestinations extends BaseModel
{
    protected $table = 'top_destinations';

    protected $fillable = [
        'descr',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
    ];
}
