<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;
use App\Models\BaseModel;

class Box extends BaseModel
{
    protected $table = 'box';

    protected $fillable = [
        'type_box',
        'unique_name',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
        'direction_id',
    ];

    public function direction(): belongsTo
    {
        return $this->belongsTo(Direction::class, 'direction_id', 'id')->withDefault();
    }

    public function getDirectionDescrAttribute(): string
    {
        return $this->direction->paymentSystem->descr . ' ' . $this->direction->currency->descr;
    }

    public function getTypeBoxDescrRuAttribute()
    {
        return ($this->type_box == 'card')
            ? Config::get('constants.type_box_ru.card')
            : Config::get('constants.type_box_ru.wallet');
    }

    public function getFormatName()
    {
        return $this->getDirectionDescrAttribute() . ': ' . $this->unique_name;
    }

    public function getBoxDataFromDirectionId($id)
    {
        $boxes = $this->where('direction_id', '=', $id)->get();
        $options = array();
        foreach ($boxes as $val) {
            $options[] = [$val->id, $val->getFormatName(),];
        }
        return $options;
    }
}
