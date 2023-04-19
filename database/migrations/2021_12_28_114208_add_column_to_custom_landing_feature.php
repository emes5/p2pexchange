<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToCustomLandingFeature extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('custom_landing_feature', function (Blueprint $table) {
            $table->tinyInteger('footer_status')->after('sub_description')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('custom_landing_feature', function (Blueprint $table) {
            $table->dropColumn('footer_status');
        });
    }
}
