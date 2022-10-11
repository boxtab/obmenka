<?php

namespace App\Models\Books;

use App\Models\BaseModel;

class Partners extends BaseModel
{
    protected $table = 'partners';

    protected $fillable = [
        'id',
        'descr',
    ];
}
