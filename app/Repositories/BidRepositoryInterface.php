<?php

namespace App\Repositories;

use App\Models\Bid;

interface BidRepositoryInterface
{
    public function __construct(Bid $bid);
}
