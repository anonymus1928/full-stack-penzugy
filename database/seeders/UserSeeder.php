<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'Test User Q',
            'email' => 'q@q.hu',
            'password' => Hash::make('q'),
        ]);

        DB::table('users')->insert([
            'name' => 'Test User A',
            'email' => 'a@a.hu',
            'password' => Hash::make('a'),
        ]);

        DB::table('users')->insert([
            'name' => 'Test User B',
            'email' => 'b@b.hu',
            'password' => Hash::make('b'),
        ]);
    }
}
