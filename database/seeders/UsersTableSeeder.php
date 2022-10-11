<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insertOrIgnore([
            'id' => 1,
            'surname' => 'Admin',
            'name' => 'Admin',
            'patronymic' => 'Admin',
            'birthday' => '2000-01-01',
            'email' => 'admin@material.com',
            'email_verified_at' => '2021-01-22 12:15:22',
            'password' => Hash::make('secret5025899'),
//            'password' => Hash::make('secret'),
            'work' => 'yes',
            'role_id' => Config('constants.role.admin'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->where('id', 1)->update([
            'surname' => 'Admin',
            'name' => 'Admin',
            'patronymic' => 'Admin',
            'birthday' => '2000-01-01',
            'email' => 'admin@material.com',
            'email_verified_at' => '2021-01-22 12:15:22',
            'password' => Hash::make('secret5025899'),
//            'password' => Hash::make('secret'),
            'work' => 'yes',
            'role_id' => Config('constants.role.admin'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insertOrIgnore([
            'id' => 2,
            'surname' => 'Черных',
            'name' => 'Алексадр',
            'patronymic' => 'Викторович',
            'birthday' => '1983-03-22',
            'email' => 'boxtab@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('chernykh5025899'),
            'work' => 'yes',
            'role_id' => Config('constants.role.admin'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $rows = DB::table('users')->where('id', 2)->update([
            'surname' => 'Черных',
            'name' => 'Алексадр',
            'patronymic' => 'Викторович',
            'birthday' => '1983-03-22',
            'email' => 'boxtab@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('chernykh5025899'),
            'work' => 'yes',
            'role_id' => Config('constants.role.admin'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insertOrIgnore([
            'id' => 3,
            'surname' => 'Бурмагин',
            'name' => 'Алексадр',
            'patronymic' => 'Юрьевич',
            'birthday' => '1997-10-22',
            'email' => 'fincentr.ob@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('UpROuDEpwi'),
            'work' => 'yes',
            'role_id' => Config('constants.role.admin'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $rows = DB::table('users')->where('id', 3)->update([
            'surname' => 'Бурмагин',
            'name' => 'Алексадр',
            'patronymic' => 'Юрьевич',
            'birthday' => '1997-10-22',
            'email' => 'fincentr.ob@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('UpROuDEpwi'),
            'work' => 'yes',
            'role_id' => Config('constants.role.admin'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insertOrIgnore([
            'id' => 4,
            'surname' => 'Компаниец',
            'name' => 'Максим',
            'patronymic' => 'Константинович',
            'birthday' => '1997-06-05',
            'email' => 'maksam07@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('uNwRooFES9xr'),
            'work' => 'yes',
            'role_id' => Config('constants.role.admin'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $rows = DB::table('users')->where('id', 4)->update([
            'surname' => 'Компаниец',
            'name' => 'Максим',
            'patronymic' => 'Константинович',
            'birthday' => '1997-06-05',
            'email' => 'maksam07@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('uNwRooFES9xr'),
            'work' => 'yes',
            'role_id' => Config('constants.role.admin'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insertOrIgnore([
            'id' => 5,
            'surname' => 'Кисиль',
            'name' => 'Марина',
            'patronymic' => 'Сергеевна',
            'birthday' => '1994-08-29',
            'email' => 'kisil.marina@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Tnf42Krp325lx'),
            'work' => 'yes',
            'role_id' => Config('constants.role.economist'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $rows = DB::table('users')->where('id', 5)->update([
            'surname' => 'Кисиль',
            'name' => 'Марина',
            'patronymic' => 'Сергеевна',
            'birthday' => '1994-08-29',
            'email' => 'kisil.marina@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Tnf42Krp325lx'),
            'work' => 'yes',
            'role_id' => Config('constants.role.economist'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        echo 'Rows: ' . $rows . PHP_EOL;
    }
}
