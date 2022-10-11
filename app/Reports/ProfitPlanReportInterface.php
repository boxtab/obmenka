<?php

namespace App\Reports;

use App\Models\Bid;

interface ProfitPlanReportInterface
{
    public function __construct( Bid $bid );
}
