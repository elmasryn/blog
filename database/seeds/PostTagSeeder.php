<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 301; $i++) { 
            DB::table('post_tag')->insert([
            'post_id' => $i,
            'tag_id' => $i < 51 ? $i : rand(1,50),
            ]);
        }

        for ($i=1; $i < 280; $i++) { 
            DB::table('post_tag')->insert([
            'post_id' => $i,
            'tag_id' => rand(1,50),
            ]);
        }

        for ($i=1; $i < 280; $i++) { 
            DB::table('post_tag')->insert([
            'post_id' => $i,
            'tag_id' => rand(1,50),
            ]);
        }
    }
}
