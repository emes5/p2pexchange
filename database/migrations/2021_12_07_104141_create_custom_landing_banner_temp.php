<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomLandingBannerTemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_landing_banner_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('landing_page_id');
            $table->string('image')->nullable();
            $table->string('video_link')->nullable();
            $table->string('title');
            $table->longText('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->string('login_button_name')->nullable();
            $table->string('register_button_name')->nullable();
            $table->tinyInteger('is_filter')->comment('1 = show and 0 = hide');
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
        Schema::dropIfExists('custom_landing_banner_temp');
    }
}
