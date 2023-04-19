<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unique_code', 180)->unique()->nullable();
            $table->bigInteger('buyer_id');
            $table->bigInteger('seller_id');
            $table->bigInteger('buyer_wallet_id')->nullable();
            $table->bigInteger('seller_wallet_id')->nullable();
            $table->bigInteger('sell_id')->nullable();
            $table->bigInteger('buy_id')->nullable();
            $table->string('coin_type');
            $table->string('currency');
            $table->decimal('rate',13,8)->default(0);
            $table->decimal('amount',13,8)->default(0);
            $table->decimal('price',13,8)->default(0);
            $table->decimal('fees',13,8)->default(0);
            $table->decimal('fees_percentage',13,8)->default(0);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_reported')->default(0);
            $table->tinyInteger('payment_status')->default(0);
            $table->tinyInteger('type')->default(1);
            $table->bigInteger('payment_id')->nullable();
            $table->string('payment_sleep')->nullable();
            $table->string('order_id')->nullable();
            $table->string('transaction_id')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
