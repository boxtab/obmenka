<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = DB::table('currency')->insertOrIgnore([
            ['id' => 1,'descr' => 'RUB', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2,'descr' => 'UAH', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3,'descr' => 'USD', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4,'descr' => 'EUR', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5,'descr' => 'BTC', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6,'descr' => 'ETH', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7,'descr' => 'ETC', 'created_at' => now(), 'updated_at' => now()],
        ]);

        echo 'Rows: ' . $rows . PHP_EOL;
    }
}
