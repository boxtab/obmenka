<?php

namespace App\Repositories;

use App\Models\Books\Currency;

interface CurrencyRepositoryInterface
{
    public function __construct( Currency $currency );
}
