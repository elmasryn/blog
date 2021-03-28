<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 21; $i++){
            DB::table('categories')->insert([
            'title_en' => 'Category '.$i,
            'title_ar' => 'قسم '.$i,
            'desc_en' => 'That is test description number '.$i.' for Category '.$i.' That is test description number '.$i.' for Category '.$i,
            'desc_ar' => 'هذا وصف تجريبيى رقم '.$i.' تابع الى قسم '.$i.' هذا وصف تجريبيى رقم '.$i.' تابع الى قسم '.$i,
            'slug' => 'Category_'.$i,
            'status' => [ '0' , '1' ][array_rand([ '0' , '1' ])],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
