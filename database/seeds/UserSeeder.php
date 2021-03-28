<?php

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
        $IsAdminExist = DB::table('users')->find(1) ? true : false;
        if ($IsAdminExist == false){
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'password' => Hash::make(123456),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        for ($i=2; $i < 51; $i++) { 
            DB::table('users')->insert([
            'name' => $i == 2 ?'user' : 'user'.$i,
            'email' => $i == 2 ?'user@test.com' : 'user'.$i.'@test.com',
            'password' => Hash::make(123456),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
