<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newSetting = Setting::first() ?? Setting::create();
        $newSetting->website_en = 'Website Name';
        $newSetting->website_ar = 'أسم الموقع';
        $newSetting->default_lang = 'en';
        $newSetting->email = 'admin@test.com';
        $newSetting->description = 'Technical skills – website testers understand software architectural concepts and workflows, know HTML or other programming languages, and can create technical documentation applicable to different software frameworks Analytical skills – tracking and identifying bugs and defects, as well as analyzing data related to software testing are important parts of a website tester’s duties. Problem-solving skills – because testing is often a complex process, website testers need to be able to troubleshoot any problems and devise methods to solve them';
        $newSetting->keywords = 'HTML, CSS, JavaScript';
        //$newSetting->icon = $data['icon'];
        $newSetting->post_publish_status = '0';
        $newSetting->comment_publish_status = '0';
        $newSetting->comment_status = '1';
        $newSetting->comment_message = 'comments will be available soon, thank you';
        $newSetting->website_status = '1';
        $newSetting->website_message = 'The web site closed temporary for maintainance';

        $newSetting->save();
    }
}
