<?php

namespace App\Repositories;

use App\Models\Books\Direction;
use Illuminate\Support\Collection;

class DirectionRepository extends Repositories implements DirectionRepositoryInterface
{
    /**
     * @var Direction
     */
    protected $model;

    /**
     * OfferRepository constructor.
     *
     * @param Direction $model
     */
    public function __construct(Direction $model)
    {
        parent::__construct($model);
    }

    /**
     * Возвращает коллекцию направлений из справочника.
     *
     * @return Collection
     */
    public function getList(): Collection
    {
        return $this->model->on()
            ->orderBy('updated_at', 'desc')
            ->get();
    }
}
