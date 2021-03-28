<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->updateOrInsert([
            'user_id' => 1,
            'role_id' => 1,
            ]);

        for ($i=2; $i < 51; $i++) { 
            DB::table('role_user')->insert([
            'user_id' => $i,
            'role_id' => rand(2,3),
            ]);
        }
    }
}
