<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';

    protected $fillable = ['descr'];
}
