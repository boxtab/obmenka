<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class IncomeExpenseType extends BaseModel
{
    use HasFactory;

    protected $table = 'income_expense_type';

    protected $fillable = [
        'id',
        'description',
    ];
}
