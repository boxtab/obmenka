<?php

namespace App\Models\Books;

use App\Models\BaseModel;

class PaymentSystem extends BaseModel
{
    protected $table = 'payment_system';

    protected $fillable = ['descr'];
}
