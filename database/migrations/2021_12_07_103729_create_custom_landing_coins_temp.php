<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomLandingCoinsTemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_landing_coins_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('landing_page_id');
            $table->unsignedInteger('serial')->nullable();
            $table->unsignedInteger('coin_id');
            $table->text('sub_description')->nullable();
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
        Schema::dropIfExists('custom_landing_coins_temp');
    }
}
