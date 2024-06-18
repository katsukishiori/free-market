<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'category' => 'メンズ',
        ];
        DB::table('categories')->insert($param);
        $param = [
            'category' => 'レディース',
        ];
        DB::table('categories')->insert($param);
        $param = [
            'category' => 'アクセサリー',
        ];
        DB::table('categories')->insert($param);
        $param = [
            'category' => '化粧品',
        ];
        DB::table('categories')->insert($param);
        $param = [
            'category' => '小物',
        ];
        DB::table('categories')->insert($param);
        $param = [
            'category' => '日用品',
        ];
        DB::table('categories')->insert($param);
        $param = [
            'category' => '家具',
        ];
        DB::table('categories')->insert($param);
        $param = [
            'category' => '電化製品',
        ];
        DB::table('categories')->insert($param);
    }
}
