<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomLandingAbout extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_landing_about', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('landing_page_id');
            $table->string('image')->nullable();
            $table->string('video_link')->nullable();
            $table->string('title');
            $table->longText('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->string('button_name')->nullable();
            $table->string('button_link')->nullable();
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
        Schema::dropIfExists('custom_landing_about');
    }
}
