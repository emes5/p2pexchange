<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomLandingPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_landing_page', function (Blueprint $table) {
            $table->increments('id');
            $table->string('page_title');
            $table->string('page_key');
            $table->string('resource_path');
            $table->string('main_primary_color')->nullable();
            $table->string('main_hover_color')->nullable();
            $table->string('temp_primary_color')->nullable();
            $table->string('temp_hover_color')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 for inactive;1 for active');
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
        Schema::dropIfExists('custom_landing_page');
    }
}
