<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManagersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 1,
            'shop_name' => 'coachtech',
            'token' => 'coachtech_token', // デフォルト値を設定
        ];
        DB::table('managers')->insert($param);
    }
}
