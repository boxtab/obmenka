<?php

namespace App\Reports;

use App\Models\Bid;
use App\Models\Constants\CurrencyConstant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProfitPlanReport extends Reports implements ProfitPlanReportInterface
{
    /**
     * @var Bid
     */
    protected $model;

    /**
     * @var array Список планов разбитых по группам источников дохода.
     */
    private $listPlan = [];

    /**
     * ProfitPlanReport constructor.
     *
     * @param Bid $model
     */
    public function __construct( Bid $model )
    {
        parent::__construct( $model );
    }

    /**
     * Подготовить данные для вывода.
     */
    public function prepareData(): void
    {
        null;
    }

    /**
     * Возвращает список планов.
     *
     * @return array|null
     */
    public function getList(): ?array
    {
        return $this->listPlan;
    }
}
