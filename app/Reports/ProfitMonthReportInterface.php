<?php

namespace App\Reports;

use App\Models\Offer;

interface ProfitMonthReportInterface
{
    public function __construct( Offer $offer );
}
