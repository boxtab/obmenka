<?php

namespace App\Providers;

use App\Repositories\AverageRateBalanceRepository;
use App\Repositories\AverageRateCalc2Repository;
use App\Repositories\AverageRateCalcRepository;
use App\Repositories\AverageRateCrossRepository;
use App\Repositories\AverageRateCalcRepositoryInterface;
use App\Repositories\AverageRateRepository;
use App\Repositories\AverageRateRepositoryInterface;
use App\Repositories\BidRepository;
use App\Repositories\BidRepositoryInterface;
use App\Repositories\BoxBalanceRepository;
use App\Repositories\BoxBalanceRepositoryInterface;
use App\Repositories\BoxRepository;
use App\Repositories\BoxRepositoryInterface;
use App\Repositories\CurrencyRepository;
use App\Repositories\CurrencyRepositoryInterface;
use App\Repositories\DirectionRepository;
use App\Repositories\DirectionRepositoryInterface;
use App\Repositories\IncomeExpenseRepository;
use App\Repositories\IncomeExpenseRepositoryInterface;
use App\Repositories\MoneyMovementRepository;
use App\Repositories\MoneyMovementRepositoryInterface;
use App\Repositories\OfferRepository;
use App\Repositories\OfferRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BidRepositoryInterface::class, BidRepository::class);
        $this->app->bind(OfferRepositoryInterface::class, OfferRepository::class);
        $this->app->bind(BoxRepositoryInterface::class, BoxRepository::class);
        $this->app->bind(BoxBalanceRepositoryInterface::class, BoxBalanceRepository::class);
        $this->app->bind(DirectionRepositoryInterface::class, DirectionRepository::class);
        $this->app->bind(AverageRateRepositoryInterface::class, AverageRateRepository::class);

//        $this->app->bind(AverageRateCalcRepositoryInterface::class, AverageRateCalcRepository::class);
//        $this->app->bind(AverageRateCalcRepositoryInterface::class, AverageRateCrossRepository::class);
//        $this->app->bind(AverageRateCalcRepositoryInterface::class, AverageRateBalanceRepository::class);
        $this->app->bind(AverageRateCalcRepositoryInterface::class, AverageRateCalc2Repository::class);

        $this->app->bind(CurrencyRepositoryInterface::class, CurrencyRepository::class);
        $this->app->bind(IncomeExpenseRepositoryInterface::class, IncomeExpenseRepository::class);
        $this->app->bind(MoneyMovementRepositoryInterface::class, MoneyMovementRepository::class);
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
