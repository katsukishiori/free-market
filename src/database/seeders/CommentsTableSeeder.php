<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 2,
            'item_id' => 1,
            'comment' => '他のカラーはありますか',
        ];
        DB::table('comments')->insert($param);

        $param = [
            'user_id' => 3,
            'item_id' => 2,
            'comment' => '値下げは可能ですか',
        ];
        DB::table('comments')->insert($param);

        $param = [
            'user_id' => 3,
            'item_id' => 3,
            'comment' => 'サイズは何ですか',
        ];
        DB::table('comments')->insert($param);

        $param = [
            'user_id' => 3,
            'item_id' => 4,
            'comment' => '発送に何日かかりますか',
        ];
        DB::table('comments')->insert($param);
    }
}
