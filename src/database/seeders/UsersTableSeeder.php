<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $param = [
            'name' => '管理者',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '店舗代表者',
            'email' => 'manager@example.com',
            'password' => Hash::make('manager123'),
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'ユーザーA',
            'email' => 'usera@example.com',
            'password' => Hash::make('usera123'),
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'ユーザーB',
            'email' => 'userb@example.com',
            'password' => Hash::make('userb123'),
        ];
        DB::table('users')->insert($param);
    }
}
