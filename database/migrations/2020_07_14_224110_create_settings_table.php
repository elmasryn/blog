<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('website_en')->nullable();
            $table->string('website_ar')->nullable();
            $table->enum('default_lang',['en','ar'])->default('en');
            $table->string('email')->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('post_publish_status')->default(0);
            $table->boolean('comment_publish_status')->default(0);
            $table->boolean('comment_status')->default(1);
            $table->text('comment_message')->nullable();
            $table->boolean('website_status')->default(1);
            $table->text('website_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
