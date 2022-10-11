<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExchangeDirectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = DB::table('exchange_direction')->insertOrIgnore([
            [
                'id'                        => 1,
                'left_payment_system_id'    => 1,
                'left_currency_id'          => 5,
                'right_payment_system_id'   => 12,
                'right_currency_id'         => 2,
                'created_at'                => now(),
                'updated_at'                => now(),
            ],
            [
                'id'                        => 2,
                'left_payment_system_id'    => 2,
                'left_currency_id'          => 6,
                'right_payment_system_id'   => 7,
                'right_currency_id'         => 2,
                'created_at'                => now(),
                'updated_at'                => now(),
            ],
            [
                'id'                        => 3,
                'left_payment_system_id'    => 6,
                'left_currency_id'          => 1,
                'right_payment_system_id'   => 15,
                'right_currency_id'         => 3,
                'created_at'                => now(),
                'updated_at'                => now(),
            ],
            [
                'id'                        => 4,
                'left_payment_system_id'    => 8,
                'left_currency_id'          => 1,
                'right_payment_system_id'   => 7,
                'right_currency_id'         => 2,
                'created_at'                => now(),
                'updated_at'                => now(),
            ],
        ]);

        echo 'Rows: ' . $rows . PHP_EOL;
    }
}
