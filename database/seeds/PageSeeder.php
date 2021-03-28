<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 21; $i++){
            DB::table('pages')->insert([
            'title_en' => 'Page '.$i,
            'title_ar' => 'صفحة '.$i,
            'body' => 'That is test body text for Page number'.$i.' That is test body text for Page number'.$i.' That is test body text for Page number'.$i.' That is test body text for Page number'.$i,
            'slug' => 'Page_'.$i,
            'status' => [ '0' , '1' ][array_rand([ '0' , '1' ])],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
