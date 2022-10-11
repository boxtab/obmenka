<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncomeExpenseChangeUpdateUserId extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('income_expense as ie')
//            ->whereNull('ie.updated_user_id')
//            ->update(['updated_user_id' => 5]);
        DB::raw('UPDATE income_expense as ie SET ie.updated_user_id = ie.created_user_id WHERE ie.updated_user_id is null');
        echo 'Need disabled income/expense seeder for change updated_user_id' . PHP_EOL;
    }
}
