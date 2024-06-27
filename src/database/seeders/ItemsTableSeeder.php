<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = [
            'id' => 1,
            'user_id' => 2,
            'condition_id' => 1,
            'name' => 'スニーカー',
            'price' => 3500,
            'description' => 'カラー：ブルー    購入後、即発送いたします。',
            'img_url' => 'sneaker.jpg',
        ];
        DB::table('items')->insert($item);
        $item = [
            'id' => 2,
            'user_id' => 2,
            'condition_id' => 2,
            'name' => '腕時計',
            'price' => 50000,
            'description' => 'カラー：ブルー    購入後、即発送いたします。',
            'img_url' => 'clock.jpg',
        ];
        DB::table('items')->insert($item);
        $item = [
            'id' => 3,
            'user_id' => 2,
            'condition_id' => 1,
            'name' => '指輪',
            'price' => 12000,
            'description' => '8号です。    購入後、即発送いたします。',
            'img_url' => 'ring.jpg',
        ];
        DB::table('items')->insert($item);
        $item = [
            'id' => 4,
            'user_id' => 2,
            'condition_id' => 1,
            'name' => 'ピアス',
            'price' => 3300,
            'description' => 'カラー：ブルー    購入後、即発送いたします。',
            'img_url' => 'earring.jpg',
        ];
        DB::table('items')->insert($item);
        $item = [
            'id' => 5,
            'user_id' => 2,
            'condition_id' => 1,
            'name' => 'バッグ',
            'price' => 18000,
            'description' => 'カラー：ホワイト    購入後、即発送いたします。',
            'img_url' => 'bag.jpg',
        ];
        DB::table('items')->insert($item);
        $item = [
            'id' => 6,
            'user_id' => 2,
            'condition_id' => 1,
            'name' => '香水',
            'price' => 2900,
            'description' => 'シトラスの香りです。    購入後、即発送いたします。',
            'img_url' => 'perfume.jpg',
        ];
        DB::table('items')->insert($item);
        $item = [
            'id' => 7,
            'user_id' => 2,
            'condition_id' => 1,
            'name' => 'トースター',
            'price' => 15000,
            'description' => 'カラー：ホワイト    購入後、即発送いたします。',
            'img_url' => 'toaster.jpg',
        ];
        DB::table('items')->insert($item);
        $item = [
            'id' => 8,
            'user_id' => 2,
            'condition_id' => 1,
            'name' => 'ロードバイク',
            'price' => 320000,
            'description' => 'カラー：ブルー    購入後、即発送いたします。',
            'img_url' => 'road-bike.jpg',
        ];
        DB::table('items')->insert($item);
        $item = [
            'id' => 9,
            'user_id' => 2,
            'condition_id' => 1,
            'name' => '椅子',
            'price' => 4800,
            'description' => 'カラー：ホワイト    購入後、即発送いたします。',
            'img_url' => 'chair.jpg',
        ];
        DB::table('items')->insert($item);
        $item = [
            'id' => 10,
            'user_id' => 2,
            'condition_id' => 1,
            'name' => 'カメラ',
            'price' => 103000,
            'description' => 'カラー：ブラック    購入後、即発送いたします。',
            'img_url' => 'camera.jpg',
        ];
        DB::table('items')->insert($item);
        $item = [
            'id' => 999,
            'user_id' => 1,
            'condition_id' => 1,
            'name' => 'カメラ',
            'price' => 103000,
            'description' => 'カラー：ブラック    購入後、即発送いたします。',
            'img_url' => 'default.jpg',
        ];
        DB::table('items')->insert($item);
    }
}
