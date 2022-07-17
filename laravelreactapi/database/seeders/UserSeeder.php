<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Yoga Hendriansyah',
            'email' => 'taurusallstar@gmail.com',
            'password' => bcrypt('sampoernamildd'),
            'role_as' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
