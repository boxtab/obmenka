<?php

namespace App\Repositories;

use App\Models\Offer;
use App\Models\IncomeExpense;

interface MoneyMovementRepositoryInterface
{
//    public function __construct( Offer $offer, IncomeExpense $incomeExpense );
    public function __construct( Offer $offer );
}
