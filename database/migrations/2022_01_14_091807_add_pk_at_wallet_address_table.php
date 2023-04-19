<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPkAtWalletAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wallet_address_histories', function (Blueprint $table) {
            $table->text('pk')->nullable()->after('address');
        });
        Schema::table('withdraw_histories', function (Blueprint $table) {
            $table->decimal('used_gas',19,8)->default(0)->after('fees');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('buyer_feedback')->nullable()->after('transaction_id');
            $table->integer('seller_feedback')->nullable()->after('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallet_address_histories', function (Blueprint $table) {
            //
        });
        Schema::table('withdraw_histories', function (Blueprint $table) {
            //
        });
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
