<?php

use App\Message;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 51; $i++){
            DB::table('messages')->insert([
            //'title' => 'title'.$i,
            //'title' => ['1','2','3'][array_rand(['1','2','3'])],
            'title_id' => [1,2,3][array_rand([1,2,3])],
            'body' => 'There is the message body '.$i.' There is the message body '.$i.' There is the message body '.$i.' There is the message body '.$i,
            'read' => ['new','old'][array_rand(['new','old'])],
            'user_id' => [$i,1,2,3,4,5,Null][array_rand([$i,1,2,3,4,5,Null])],
            'name' => ['Mohamed','Ali','Mostafa'][array_rand(['Mohamed','Ali','Mostafa'])],
            'email' => ['jo'.$i.'@test.com','fo'.$i.'@test.com','bo'.$i.'@test.com'][array_rand(['jo@test.com','fo@test.com','bo@test.com'])],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'deleted_at' => $i > 35 && $i < 40 ? date('Y-m-d H:i:s') : Null,
            ]);
        }

        for ($i=1; $i < 51; $i++){
            DB::table('messages')->where('id',$i)->update([
            'name' =>  isset(Message::find($i)->user_id) ? Message::find($i)->User->name : ['Mohamed','Ali','Mostafa'][array_rand(['Mohamed','Ali','Mostafa'])],
            'email' => isset(Message::find($i)->user_id) ? Message::find($i)->User->email : ['jo'.$i.'@test.com','fo'.$i.'@test.com','bo'.$i.'@test.com'][array_rand(['jo@test.com','fo@test.com','bo@test.com'])],
            ]);
        }
    }
} 
