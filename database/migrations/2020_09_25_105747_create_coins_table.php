<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unique_code', 180)->unique()->nullable();
            $table->string('name');
            $table->string('type',20)->unique();
            $table->string('image')->nullable();
            $table->text('details')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_withdrawal')->default(1);
            $table->tinyInteger('is_deposit')->default(1);
            $table->tinyInteger('is_buy')->default(1);
            $table->tinyInteger('is_sell')->default(1);
            $table->decimal('minimum_withdrawal',19,8)->default(.00001);
            $table->decimal('maximum_withdrawal',19,8)->default(99999999.9999);
            $table->decimal('minimum_trade_size',19,8)->default(.001);
            $table->decimal('maximum_trade_size',19,8)->default(99999999.9999);
            $table->decimal('withdrawal_fees',19,8)->default(.001);
            $table->decimal('trade_fees',19,8)->default(.001);
            $table->decimal('escrow_fees',19,8)->default(.001);
            $table->decimal('max_withdrawal_per_day',19,8)->default(999);
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
        Schema::dropIfExists('coins');
    }
}
