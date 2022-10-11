<?php

namespace App\Models;

use App\Models\Books\Direction;
use App\Models\Books\Client;
use App\Models\Books\TopDestinations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bid extends BaseModel
{
    protected $table = 'bid';

    protected $fillable = [
        'bid_number',
        'top_destinations_id',
        'client_id',
        'direction_get_id',
        'direction_give_id',
        'manager_user_id',
        'note',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
    ];

    public function topDestinations(): BelongsTo
    {
        return $this->belongsTo(TopDestinations::class, 'top_destinations_id', 'id')
            ->withDefault();
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'id')->withDefault();
    }

    public function directionGet(): BelongsTo
    {
        return $this->belongsTo(Direction::class, 'direction_get_id', 'id')
            ->withDefault();
    }

    public function directionGive(): BelongsTo
    {
        return $this->belongsTo(Direction::class, 'direction_give_id', 'id')
            ->withDefault();
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_user_id', 'id')
            ->withDefault();
    }

    public function offers(): hasMany
    {
        return $this->hasMany(Offer::class, 'bid_id', 'id');
    }

    /**
     * Какую сумму получаем по заявке.
     *
     * @return string
     */
    public function getTotalAmountGetAttribute(): string
    {
        return $this->offers->where('enum_inc_exp', 'inc')->sum('amount');
    }

    /**
     * Какую сумму отдаем по заявке.
     *
     * @return string
     */
    public function getTotalAmountGiveAttribute(): string
    {
        return $this->offers->where('enum_inc_exp', 'exp')->sum('amount');
    }

    /**
     * Направление по которому получаем.
     * Направление = платежная система + валюта.
     *
     * @return string
     */
    public function getDirectionGetDescrAttribute(): string
    {
        return $this->directionGet->paymentSystem->descr . ' ' . $this->directionGet->currency->descr;
    }

    /**
     * Направление по которому отдаем.
     * Направление = платежная система + валюта.
     *
     * @return string
     */
    public function getDirectionGiveDescrAttribute(): string
    {
        return $this->directionGive->paymentSystem->descr . ' ' . $this->directionGive->currency->descr;
    }

    /**
     * По id пользователя возвращает полное имя пользователя.
     *
     * @param int $userId
     * @return string
     */
    private function getFullNameById( int $userId ): string
    {
        $fullName = '';
        if ( ! is_null( $userId ) ) {
            $user       = User::on()->find( $userId );
            $surname    = ( ! is_null( $user->surname ) ) ? $user->surname : '';
            $name       = ( ! is_null( $user->name ) ) ? $user->name : '';
            $patronymic = ( ! is_null( $user->patronymic ) ) ? $user->patronymic : '';
            $fullName = $surname . ' ' . $name . ' ' . $patronymic;
        }
        return $fullName;
    }

    /**
     * Кто добавил.
     *
     * @return string
     */
    public function getWhoAddedAttribute(): string
    {
        return $this->getFullNameById( $this->created_user_id );
    }

    /**
     * Кто изменил.
     *
     * @return string
     */
    public function getWhoChangedAttribute(): string
    {
        return $this->getFullNameById( $this->updated_user_id );
    }
}
