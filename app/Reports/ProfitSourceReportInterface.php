<?php

namespace App\Reports;

use App\Models\Bid;

interface ProfitSourceReportInterface
{
    public function __construct( Bid $bid );
}
