<?php

namespace App\Reports;

use App\Models\Bid;

interface ProfitDirectionReportInterface
{
    public function __construct( Bid $bid );
}
