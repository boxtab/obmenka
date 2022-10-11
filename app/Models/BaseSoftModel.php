<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseSoftModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_user_id = Auth()->user()->id;
        });

        static::updating(function ($model) {
            $model->updated_user_id = Auth()->user()->id;
        });

        static::deleting(function ($model) {
            $model->deleted_user_id = Auth()->user()->id;
            $model->save();
        });
    }

    public function createdUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_user_id', 'id')
            ->withDefault();
    }

    public function updatedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_user_id', 'id')
            ->withDefault();
    }

    public function deletedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_user_id', 'id')
            ->withDefault();
    }

    public function getCreatedFullNameAttribute()
    {
        $fullName = '';
        if ( $this->createdUser !== null ) {
            $fullName = $this->createdUser->surname . ' ' .
                substr($this->createdUser->name,0, 1) . '. ' .
                substr($this->createdUser->patronymic,0, 1) . '.';
        }
        return $fullName;
    }

    public function getUpdatedFullNameAttribute()
    {
        $fullName = '';
        if ( $this->updatedUser !== null ) {
            $fullName = $this->updatedUser->surname . ' ' .
                substr($this->updatedUser->name,0, 1) . '. ' .
                substr($this->updatedUser->patronymic,0, 1) . '.';
        }
        return $fullName;
    }
}
