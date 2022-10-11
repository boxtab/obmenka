<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use League\Flysystem\Config;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = DB::table('role')->insertOrIgnore([
            [
                'id' => Config('constants.role.admin'),
                'descr' => 'Админ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Config('constants.role.economist'),
                'descr' => 'Экономист',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Config('constants.role.manager'),
                'descr' => 'Менеджер',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('role')->where('id', Config('constants.role.admin'))->update([
            'descr' => 'Админ',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('role')->where('id', Config('constants.role.economist'))->update([
            'descr' => 'Экономист',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('role')->where('id', Config('constants.role.manager'))->update([
            'descr' => 'Менеджер',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        echo 'Rows: ' . $rows . PHP_EOL;
    }
}
