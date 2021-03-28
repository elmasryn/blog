<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
            'name' => 'Admin',
            'desc' => 'The Manager who can controll with all web site and has controll with Admin panel',
            ],
            [
            'name' => 'Editor',
            'desc' => 'The Author who can write the all Posts',
            ],
            [
            'name' => 'User',
            'desc' => 'The normal user who can make comments on exist Posts',
            ],
            ]);
    }
}
