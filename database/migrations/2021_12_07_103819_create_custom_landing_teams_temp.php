<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomLandingTeamsTemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_landing_teams_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('landing_page_id');
            $table->unsignedInteger('serial')->nullable();
            $table->string('image')->nullable();
            $table->string('sub_title')->nullable();
            $table->text('sub_description')->nullable();
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
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
        Schema::dropIfExists('custom_landing_teams_temp');
    }
}
