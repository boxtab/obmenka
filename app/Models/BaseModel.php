<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_user_id = Auth()->user()->id;
        });

        static::updating(function ($model) {
            $model->updated_user_id = Auth()->user()->id;
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

    /**
     * Фамилия И.О.
     *
     * @param string $relationUser
     *  Отношение к таблице пользователей.
     * @return string
     */
    private function getFullName( string $relationUser ): string
    {
        $fullName = '-';
        if ( ! is_null( $this->$relationUser ) ) {
            $fullName = $this->$relationUser->surname . ' ' .
                mb_substr($this->$relationUser->name, 0, 1) . '.' .
                mb_substr($this->$relationUser->patronymic, 0, 1) . '.';
        }
        return $fullName;
    }

    /**
     * ФИО пользователя который создал запись.
     *
     * @return string
     */
    public function getCreatedFullNameAttribute(): string
    {
        return $this->getFullName( 'createdUser' );
    }

    /**
     * ФИО пользователя который редактировал запись.
     *
     * @return string
     */
    public function getUpdatedFullNameAttribute(): string
    {
        return $this->getFullName( 'createdUser' );
    }

    /**
     * ФИО пользователя который удалил запись.
     *
     * @return string
     */
    public function getDeletedFullNameAttribute(): string
    {
        return $this->getFullName( 'deletedUser' );
    }
}
