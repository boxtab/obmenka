<?php

namespace App\Models;

use App\Models\Books\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class User
 * @package App\Models
 *
 * @property int $id
 * @property string $surname
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    public $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'surname',
        'name',
        'patronymic',
        'birthday',
        'email',
        'password',
        'work',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Роль из справочника.
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id')
            ->withDefault();
    }

    /**
     * Фамилия И.О.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->surname . ' ' . mb_substr($this->name, 0, 1) . '.' . mb_substr($this->patronymic, 0, 1) . '.';
    }

    /**
     * Работает / не работает пользователь.
     * Работает - доступ на авторизацию разрешен.
     * Не работает - доступ на авторизацию запрещен.
     *
     * @return string
     */
    public function getIsWorkAttribute()
    {
        return ($this->work === 'yes') ? 'Да' : 'Нет';
    }
}
