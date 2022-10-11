<?php

namespace App\Repositories;

use App\Models\AverageRate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AverageRateCalc2Repository extends Repositories implements AverageRateCalcRepositoryInterface
{
    /**
     * @var AverageRate
     */
    protected $model;

    /**
     * AverageRateRepository constructor.
     *
     * @param AverageRate $model
     */
    public function __construct( AverageRate $model )
    {
        parent::__construct( $model );
    }

    public function calc()
    {
        $this->model->on()->truncate();

        $instanceAverageRate = new \App\Modules\AverageRate\AverageRate();
        $instanceAverageRate->processing();
        $averageRate = $instanceAverageRate->getAverageRate();

        DB::table('average_rate')->insert( $averageRate );
//        AverageRate::on()->insert( $averageRate );
    }
}
