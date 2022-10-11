<?php

namespace App\Models\Books;

use App\Models\BaseModel;

class Client extends BaseModel
{
    protected $table = 'clients';

    protected $fillable = [
        'fullname',
        'email',
        'phone',
        'note',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
    ];

    /**
     * Полная информация о клиенте.
     *
     * @return string
     */
    public function getFullInfoAttribute(): string
    {
        return $this->fullname .
            ( ! is_null($this->email ) ? ' / ' . $this->email : '' ) .
            ( ! is_null($this->phone ) ? ' / ' . $this->phone  : '' );
    }
}
