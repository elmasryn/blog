<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 301; $i++){
            DB::table('posts')->insert([
            'user_id' => $i < 51 ? $i : rand(1,50),
            'category_id' => $i < 21 ? $i : rand(1,20),
            'title' => 'Post '.$i,
            'body' => 'That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i.' That is test body text for Post number'.$i,
            'thumbnail' => ['img/thumbnail/2.jpg','img/thumbnail/3.jpg','img/thumbnail/4.jpg',Null][array_rand(['img/thumbnail/2.jpg','img/thumbnail/3.jpg','img/thumbnail/4.jpg',Null])],
            'slug' => 'Post_'.$i,
            'status' => [ '0' , '1' ][array_rand([ '0' , '1' ])],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
