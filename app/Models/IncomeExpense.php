<?php

namespace App\Models;

use App\Models\Books\Box;
use App\Models\Books\DDS;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncomeExpense extends BaseModel
{
    protected $table = 'income_expense';

    protected $fillable = [
        'income_expense',
        'income_expense_type_id',
        'dds_id',
        'partner_id',
        'box_id',
        'amount',
        'rate',
        'expense_id',
        'note',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
    ];

    public function getIncomeExpenseDescrAttribute(): string
    {
        return $this->income_expense === 'income' ? 'Приход' : 'Расход';
    }

    public function dds(): BelongsTo
    {
        return $this->belongsTo(DDS::class, 'dds_id', 'id')
            ->withDefault();
    }

    public function box(): BelongsTo
    {
        return $this->belongsTo(Box::class, 'box_id', 'id')
            ->withDefault();
    }

    public function getAmountRubAttribute()
    {
        return $this->amount * $this->rate;
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d\TH:i');
    }
}
