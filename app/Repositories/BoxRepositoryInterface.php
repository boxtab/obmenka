<?php

namespace App\Repositories;

use App\Models\Books\Box;

interface BoxRepositoryInterface
{
    public function __construct(Box $box);
}
