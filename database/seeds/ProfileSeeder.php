<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 51; $i++){
            DB::table('profiles')->insert([
            'user_id' => $i,
            'avatar' => ['img/avatar/2.jpg','img/avatar/3.jpg','img/avatar/4.png',Null][array_rand(['img/avatar/2.jpg','img/avatar/3.jpg','img/avatar/4.png',Null])],
            'lang' => ['en','ar',Null][array_rand(['en','ar',Null])],
            'about' => 'There are some script about me'.$i.' There are some script about me '.$i.' There are some script about me '.$i.' There are some script about me '.$i,
            'pagination' => [6,12,Null][array_rand([6,12,Null])],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
