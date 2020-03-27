<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => env('SUPERADMIN_USERNAME', 'antelope'),
            'password' => Hash::make(env('SUPERADMIN_PASSWORD' ,'password')),
            'name' => 'AntelopePHP',
            'rank' => 'other_guest',
            'website_id' => 1,
            'department_id' => null,
            'temp_password' => 0,
        ]);

        DB::table('role_user')->insert([
            'role_id' => 1,
            'user_id' => 1,
        ]);
    }
}