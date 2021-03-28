<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Message_titleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messageTitles_en = [1 => 'General Customer Service' , 2 =>'Suggestions' , 3 => 'Golden user request'];
        $messageTitles_ar = [1 => 'خدمة الأعضاء بشكل عام' , 2 =>'الأقتراحات' , 3 => 'طلب عضوية ذهبية'];
        for ($i=1; $i < 4; $i++){
            DB::table('message_titles')->insert([
            'title_en' => $messageTitles_en[$i],
            'title_ar' => $messageTitles_ar[$i],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
