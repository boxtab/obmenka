<?php

namespace App\Repositories;

use App\Models\Books\Direction;

interface DirectionRepositoryInterface
{
    public function __construct(Direction $direction);
}
