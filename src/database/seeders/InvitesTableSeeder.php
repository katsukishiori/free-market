<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InvitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Invite::factory(5)->create();
    }
}
