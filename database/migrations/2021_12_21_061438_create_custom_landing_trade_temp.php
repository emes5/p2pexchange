<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomLandingTradeTemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_landing_trade_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('landing_page_id');
            $table->string('image_one')->nullable();
            $table->string('image_two')->nullable();
            $table->string('video_link')->nullable();
            $table->string('app_store_link')->nullable();
            $table->string('play_store_link')->nullable();
            $table->string('android_apk_link')->nullable();
            $table->string('windows_link')->nullable();
            $table->string('linux_link')->nullable();
            $table->string('mac_link')->nullable();
            $table->string('api_link')->nullable();
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
        Schema::dropIfExists('custom_landing_trade_temp');
    }
}
