<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Constants\IncomeExpenseTypeConstant;

class IncomeExpenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = DB::table('income_expense_type')->insertOrIgnore([
            [
                'id' => IncomeExpenseTypeConstant::PARTNERS,
                'description' => 'Партнеры',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => IncomeExpenseTypeConstant::INCOME_UNFINISHED,
                'description' => 'Приход незавершенка',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => IncomeExpenseTypeConstant::EXPENSE_UNFINISHED,
                'description' => 'Расход незавершенка',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => IncomeExpenseTypeConstant::COMPANY_EXPENSE,
                'description' => 'Расход фирмы',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => IncomeExpenseTypeConstant::COMPANY_INCOME,
                'description' => 'Приход фирмы',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => IncomeExpenseTypeConstant::OUTPUT_CARD_CARD,
                'description' => 'Вывод карта/карта',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => IncomeExpenseTypeConstant::OUTPUT_CARD_CASH,
                'description' => 'Вывод карта/нал',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => IncomeExpenseTypeConstant::OUTPUT_WALLET_CARD,
                'description' => 'Вывод кошелек/карта',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => IncomeExpenseTypeConstant::OUTPUT_WALLET_WALLET,
                'description' => 'Вывод кошелек/кошелек',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => IncomeExpenseTypeConstant::OUTPUT_EXCHANGE,
                'description' => 'Вывод обмен (разные валюты)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        echo 'Rows: ' . $rows . PHP_EOL;
    }
}
