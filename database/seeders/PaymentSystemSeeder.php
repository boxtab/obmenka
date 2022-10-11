<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = DB::table('payment_system')->insertOrIgnore([
            ['id' => 1, 'descr' => 'Bitcoin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'descr' => 'Ethereum', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'descr' => 'Litecoin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'descr' => 'Ripple', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'descr' => 'Tether', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'descr' => 'Сбербанк', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'descr' => 'Приват', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'descr' => 'Qiwi', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'descr' => 'Яндекс.Деньги', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'descr' => 'Advanced', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'descr' => 'Perfect money', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'descr' => 'Visa/MasterCard', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'descr' => 'Тинькофф', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'descr' => 'Альфа-Банк', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'descr' => 'Наличные', 'created_at' => now(), 'updated_at' => now()],
        ]);

        echo 'Rows: ' . $rows . PHP_EOL;
    }
}
