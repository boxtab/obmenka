<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Reports\ProfitDayReportInterface;
use App\Reports\ProfitDayReport;
use App\Reports\ProfitDirectionReportInterface;
use App\Reports\ProfitDirectionReport;
use App\Reports\ProfitMonthReportInterface;
use App\Reports\ProfitMonthReport;
use App\Reports\ProfitSourceReportInterface;
use App\Reports\ProfitSourceReport;
use App\Reports\ProfitPlanReportInterface;
use App\Reports\ProfitPlanReport;

class ReportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind( ProfitDayReportInterface::class, ProfitDayReport::class );
        $this->app->bind( ProfitMonthReportInterface::class, ProfitMonthReport::class );
        $this->app->bind( ProfitDirectionReportInterface::class, ProfitDirectionReport::class );
        $this->app->bind( ProfitSourceReportInterface::class, ProfitSourceReport::class );
        $this->app->bind( ProfitPlanReportInterface::class, ProfitPlanReport::class );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
