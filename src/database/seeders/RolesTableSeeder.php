<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'id' => 1,
            'name' => '管理者',
            'role' => 'admin',
        ];
        DB::table('roles')->insert($param);

        $param = [
            'id' => 2,
            'name' => '店舗代表者',
            'role' => 'manager',
        ];
        DB::table('roles')->insert($param);

        $param = [
            'id' => 3,
            'name' => '利用者',
            'role' => 'user',
        ];
        DB::table('roles')->insert($param);
    }
}
