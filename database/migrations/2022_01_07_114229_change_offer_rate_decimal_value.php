<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeOfferRateDecimalValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buys', function (Blueprint $table) {
            $table->decimal('coin_rate', 19, 8)->default(0)->change();
            $table->decimal('rate_percentage', 19, 8)->default(0)->change();
            $table->decimal('market_price', 19, 8)->default(0)->change();
        });
        Schema::table('sells', function (Blueprint $table) {
            $table->decimal('coin_rate', 19, 8)->default(0)->change();
            $table->decimal('rate_percentage', 19, 8)->default(0)->change();
            $table->decimal('market_price', 19, 8)->default(0)->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
