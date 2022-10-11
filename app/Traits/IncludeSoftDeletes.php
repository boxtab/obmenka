<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;

trait IncludeSoftDeletes
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
}
