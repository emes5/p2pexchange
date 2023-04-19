<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoinTypeAtAffiliationHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('affiliation_histories', function (Blueprint $table) {
            $table->string('coin_type')->nullable()->after('level');
            $table->bigInteger('wallet_id')->nullable()->after('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliation_histories', function (Blueprint $table) {
            //
        });
    }
}
