<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Website_contentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 5; $i++){
            DB::table('website_contents')->insert([
            'value' => 'Link '.$i,
            'link' => 'http://127.0.0.1:8000/page/Page_'.$i,
            'area_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        for ($i=5; $i < 9; $i++){
            DB::table('website_contents')->insert([
            'value' => 'Link '.$i,
            'link' => 'http://127.0.0.1:8000/posts?category=Category_'.$i,
            'area_id' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        for ($i=9; $i < 13; $i++){
            DB::table('website_contents')->insert([
            'value' => 'Link '.$i,
            'link' => 'http://127.0.0.1:8000/posts/Post_'.$i,
            'area_id' => 3,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        for ($i=4; $i < 7; $i++){
            DB::table('website_contents')->insert([
            'value' => array_search($i,['pages'=>4,'categories'=>5,'posts'=>6]),
            'area_id' => $i,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

            DB::table('website_contents')->insert([
            'value' => 'Footer content',
            'area_id' => 7,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);

            DB::table('website_contents')->insert([
            'value' => 'Here you can use rows and columns to organize your footer content. Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
            'area_id' => 8,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);

            DB::table('website_contents')->insert([
            'link' => 'http://facebook.com/',
            'area_id' => 9,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);

            DB::table('website_contents')->insert([
            'link' => 'http://twitter.com/',
            'area_id' => 10,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);

            DB::table('website_contents')->insert([
            'link' => 'http://google.com/',
            'area_id' => 11,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);

            DB::table('website_contents')->insert([
            'link' => 'http://linkedin.com/',
            'area_id' => 12,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);

            DB::table('website_contents')->insert([
            'link' => 'http://gmail.com/',
            'area_id' => 13,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);

            DB::table('website_contents')->insert([
            'link' => 'http://gmail.com/',
            'area_id' => 14,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);

            DB::table('website_contents')->insert([
            'value' => 'addds.png',
            'link' => 'http://yahoo.com/',
            'area_id' => 15,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);
    }
}
