<?php

namespace App\Repositories;

use App\Models\AverageRate;
use App\Models\Constants\CurrencyConstant;
use App\Repositories\AverageRateCalcRepositoryInterface;
use App\Repositories\Repositories;
use App\Utility\CurrencyBalanceUtility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;

class AverageRateCrossRepository extends Repositories implements AverageRateCalcRepositoryInterface
{
    /**
     * @var AverageRate
     */
    protected $model;

    /**
     * @var CurrencyBalanceUtility
     */
    private $balance;

    /**
     * @var array
     */
    private $united;

    /**
     * @var array
     */
    private $averageRate = [];

    /**
     * AverageRateRepository constructor.
     *
     * @param AverageRate $model
     */
    public function __construct( AverageRate $model )
    {
        parent::__construct( $model );
    }

    /**
     * Расчет средних курсов и заполнение таблицы средних курсов.
     */
    public function calc()
    {
        // Очистка таблицы средних курсов.
        $this->model->on()->truncate();

        // Заполнение массива остатков.
        $this->balance = new CurrencyBalanceUtility();

        // Заполняем оборот средств из заявок и прихода/расхода.
        $this->united = $this->fillUnited();

        // Заполняем массив средних курсов.
        $this->fillAverageRate();

        DB::table('average_rate')->insert( $this->averageRate );
//        AverageRate::on()->insert( $averageRate );
    }

    /**
     * Извлечь заявки из базы данных.
     *
     * array:2 [▼
     *      0 => array:5 [▼
     *          "work_date" => "2021-05-03"
     *          "currency_id_income" => 37
     *          "currency_id_expense" => 1
     *          "amount_income" => 0.127433075
     *          "amount_expense" => 561336.43841102
     * ]
     */
    public function retrieveBid(): Builder
    {
        return DB::table('bid as b')
            ->select(DB::raw("
                DATE( b.updated_at ) as work_date,
                d_get.currency_id as currency_id_income,
                d_give.currency_id as currency_id_expense,
                SUM( IF( o.enum_inc_exp = 'inc', TRIM(o.amount) + 0, 0 ) ) as amount_income,
                SUM( IF( o.enum_inc_exp = 'exp', TRIM(o.amount) + 0, 0 ) ) as amount_expense
            "))
            ->leftJoin('direction as d_get', 'b.direction_get_id', '=', 'd_get.id')
            ->leftJoin('direction as d_give', 'b.direction_give_id', '=', 'd_give.id')
            ->leftJoin('offer as o', 'b.id', '=', 'o.bid_id')
            ->where('d_get.currency_id', '<>', CurrencyConstant::RUB)
            ->groupByRaw('DATE(b.updated_at), d_get.currency_id, d_give.currency_id');
    }

    /**
     * Извлечь приход/расход из базы данных.
     *
     * array:2 [▼
     *      0 => array:5 [▼
     *          "work_date" => "2021-05-03"
     *          "currency_id_income" => 37
     *          "currency_id_expense" => 1
     *          "amount_income" => 0.127433075
     *          "amount_expense" => 561336.43841102
     * ]
     */
    public function retrieveIncExp(): Builder
    {
        $currencyRub = CurrencyConstant::RUB;

        return DB::table('income_expense as ie')
            ->select(DB::raw("
                DATE( ie.updated_at ) as work_date,
                d.currency_id as currency_id_income,
                $currencyRub as currency_id_expense,
                SUM( TRIM(ie.amount) + 0 ) as amount_income,
                SUM( (TRIM(ie.amount) + 0) * ie.rate ) as amount_expense
            "))
            ->leftJoin('box as b', 'ie.box_id', '=', 'b.id')
            ->leftJoin('direction as d', 'b.direction_id', '=', 'd.id')
            ->where('ie.income_expense' , '=', 'income')
            ->where('d.currency_id' , '<>', CurrencyConstant::RUB)
            ->groupByRaw('DATE( ie.updated_at ), d.currency_id');
    }

    /**
     * Объеденить заявки с приходом/расходом.
     *
     * @return array
     */
    public function fillUnited(): array
    {
        $bidIncomeExpense = $this->retrieveBid()
            ->union( $this->retrieveIncExp() );

        return DB::query()->fromSub( $bidIncomeExpense, 'bie' )
            ->select(DB::raw("
                bie.work_date,
                bie.currency_id_income,
                bie.currency_id_expense,
                SUM( bie.amount_income ) as amount_income,
                SUM( bie.amount_expense ) as amount_expense
            "))
            ->groupByRaw('bie.work_date, bie.currency_id_income, bie.currency_id_expense')
            ->orderBy('bie.work_date', 'ASC')
            ->orderBy('bie.currency_id_income', 'ASC')
            ->orderBy('bie.currency_id_expense', 'ASC')
            ->get()
            ->map( function ( $item ) {
                return (array)$item;
            })
            ->toArray();
    }

    /**
     * Заполнить средние курсы.
     *
     * Массив на выходе.
     *
     * array:16 [▼
     *  0 => array:3 [▼
     *      "rate_date" => "2021-03-12"
     *      "currency_id" => 40
     *      "rate" => 76.406861007883
     *  ]
     */
    public function fillAverageRate()
    {
        $groupCurrencyDay = [];
//        exec('echo "" > ' . storage_path('logs/laravel-2021-05-22.log'));

        // Проходимся по всем сгруппированным приходам валюты (заявкаи + приход расход).
        for ( $i = 0; $i < count( $this->united ); $i++ ) {
            // Если группа пустая то заносим первый элемент и переходим к следующе строке
            if ( empty( $groupCurrencyDay ) ) {
                array_push( $groupCurrencyDay, $this->united[ $i ] );
                continue;
            }

            // Если в группе что-то есть то проверяем относится ли текущая строка к группе
            // и если да то заносим ее в группу и переходим к следующей строке
            if ( $groupCurrencyDay[0]['work_date'] === $this->united[ $i ]['work_date']
                &&
                $groupCurrencyDay[0]['currency_id_income'] === $this->united[ $i ]['currency_id_income']
            ) {
                array_push( $groupCurrencyDay, $this->united[ $i ] );
                continue;
            }

            // Обработка группы
            $this->groupToRate( $groupCurrencyDay );

            // Очистка группы и занесение нового элемента который будет первым в ней
            $groupCurrencyDay = [];
            array_push( $groupCurrencyDay, $this->united[ $i ] );
        }
    }

    /**
     * Получаем группу, обрабатываем ее и добавляем новый элемент в массив курсов.
     *
     * Вход:
     * [
     *      [
     *          "work_date" => "2021.04.01",
     *          "currency_id_income" => 37,
     *          "currency_id_expense" => 1,
     *          "amount_income" => 0.00434,
     *          "amount_expense" => 47524.12,
     *      ],
     * ]
     *
     * Выход:
     *  [
     *      "rate_date" => "2021-03-12"
     *      "currency_id" => 40
     *      "rate" => 76.406861007883
     *  ]
     *
     * @param array $group
     */
    private function groupToRate( array $group ): void
    {
        // Инициализируем элемент курса валюты.
        $rateDate = $group[0]['work_date'];
        $currencyId = $group[0]['currency_id_income'];
        $weightedRub = $this->balance->getRub( $currencyId );
        $weightedCurrency = $this->balance->getCurrency( $currencyId );

        // Суммируем сумму в валюте и сумму в рубле, если отдавали не рубль то извлекаем курс и приводим к рублю.
        foreach ( $group as $purchase ) {
            $weightedCurrency += $purchase['amount_income'];
            if ( $purchase['currency_id_expense'] !== CurrencyConstant::RUB ) {
                $rate = $this->balance->getRate( $purchase['currency_id_expense'] );
                $weightedRub += $purchase['amount_expense'] * $rate;
            } else {
                $weightedRub += $purchase['amount_expense'];
            }
        }

        // Вычисляем средневзвешенный остаток.
        $weightedRub += $weightedRub;
        $weightedCurrency += $weightedCurrency;

        // Записываем средневзвешенный остаток в массив остатков по валютам.
        $this->balance->setRub( $currencyId, $weightedRub );
        $this->balance->setCurrency( $currencyId, $weightedCurrency );

        // Отправляем элемент курса валюты в массив.
        $this->averageRate[] = [
            'rate_date'         => $rateDate,
            'currency_id'       => $currencyId,
            'rate'              => $weightedRub / $weightedCurrency,
            'created_at'        => now(),
            'updated_at'        => now(),
            'created_user_id'   => Auth::user()->id,
            'updated_user_id'   => Auth::user()->id,
        ];
    }
}
