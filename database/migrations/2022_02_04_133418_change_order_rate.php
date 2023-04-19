<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeOrderRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('rate',19,8)->default(0)->change();
            $table->decimal('amount',19,8)->default(0)->change();
            $table->decimal('price',19,8)->default(0)->change();
            $table->decimal('fees',19,8)->default(0)->change();
            $table->decimal('fees_percentage',19,8)->default(0)->change();
        });
        Schema::table('escrows', function (Blueprint $table) {
            $table->decimal('amount',19,8)->default(0)->change();
            $table->decimal('fees',19,8)->default(0)->change();
            $table->decimal('fees_percentage',19,8)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
        Schema::table('escrows', function (Blueprint $table) {
            //
        });
    }
}
