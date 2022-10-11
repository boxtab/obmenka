<?php

namespace App\Repositories;

use App\Models\AverageRate;

interface AverageRateCalcRepositoryInterface
{
    public function __construct( AverageRate $averageRate );
}
