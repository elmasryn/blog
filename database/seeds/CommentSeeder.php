<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 901; $i++) {
            DB::table('comments')->insert([
                'user_id' => $i < 51 ? $i : rand(1, 50),
                'post_id' => $i < 301 ? $i : rand(1, 300),
                'body' => 'That is test body text for Comment number' . $i . ' That is test body text for Comment number' . $i . ' That is test body text for Comment number' . $i . ' That is test body text for Comment number' . $i . ' That is test body text for Comment number' . $i,
                'name' => ['Mohamed', 'Ali', 'Mostafa'][array_rand(['Mohamed', 'Ali', 'Mostafa'])],
                'status' => ['0', '1'][array_rand(['0', '1'])],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        for ($i = 1; $i < 401; $i++) {
            DB::table('comments')->where('id', rand(1, 900))->update([
                'user_id' => Null,
            ]);
        }
    }
}
