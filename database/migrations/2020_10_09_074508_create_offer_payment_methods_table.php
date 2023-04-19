<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_payment_methods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('offer_id');
            $table->bigInteger('payment_method_id');
            $table->tinyInteger('offer_type')->default(1);
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
        Schema::dropIfExists('offer_payment_methods');
    }
}
