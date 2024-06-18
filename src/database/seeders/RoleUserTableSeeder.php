<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = [
            [
                'user_id' => 1,
                'manager_id' => 999,
                'role_id' => 1,
            ],
            [
                'user_id' => 2,
                'manager_id' => 1,
                'role_id' => 2,
            ],
            [
                'user_id' => 3,
                'manager_id' => 999,
                'role_id' => 3,
            ],
            [
                'user_id' => 4,
                'manager_id' => 999,
                'role_id' => 3,
            ],
        ];

        DB::table('role_user')->insert($params);
    }
}
