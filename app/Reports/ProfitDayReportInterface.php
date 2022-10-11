<?php

namespace App\Reports;

use App\Models\Bid;

interface ProfitDayReportInterface
{
    public function __construct( Bid $bid );
}
