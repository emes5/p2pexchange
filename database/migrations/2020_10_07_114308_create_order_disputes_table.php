<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDisputesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_disputes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unique_code', 180)->unique()->nullable();
            $table->bigInteger('order_id');
            $table->bigInteger('user_id');
            $table->bigInteger('reported_user');
            $table->text('reason_heading');
            $table->longText('details')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('type')->default(1);
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('order_disputes');
    }
}
