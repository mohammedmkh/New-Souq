<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->integer('store_id');
            $table->integer('buyer_id');
            $table->integer('datetime');
            $table->double('total-price');
            $table->integer('currency_id');
            $table->integer('sent-by-seller');
            $table->integer('sent-by-seller_id');
            $table->integer('recieved-by-buyer');
            $table->integer('recieved-as-ordered');
            $table->integer('recieving-date-time');
            $table->string('tracking-number');
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
