<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sells', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unique_code', 180)->unique()->nullable();
            $table->bigInteger('coin_id');
            $table->bigInteger('user_id');
            $table->string('coin_type');
            $table->bigInteger('wallet_id');
            $table->string('country');
            $table->string('address')->nullable();
            $table->string('currency');
            $table->string('ip');
            $table->decimal('coin_rate',13,8)->default(0);
            $table->decimal('rate_percentage',13,8)->default(0);
            $table->decimal('market_price',13,8)->default(0);
            $table->tinyInteger('rate_type')->default(1);
            $table->tinyInteger('price_type')->default(1);
            $table->bigInteger('minimum_trade_size')->default(0);
            $table->bigInteger('maximum_trade_size')->default(0);
            $table->string('headline');
            $table->longText('terms')->nullable();
            $table->longText('instruction')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('sells');
    }
}
