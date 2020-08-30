<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('product_id');
            $table->integer('store_id');
            $table->integer('buyer_id');
            $table->integer('datetime');
            $table->double('product-price');
            $table->integer('product-currency_id');
            $table->integer('product-status');
            $table->integer('product-category_id');
            $table->string('product-photos');
            $table->string('product-title');
            $table->string('product-specifications');
            $table->string('ordered-quantity');
            $table->boolean('recieved-as-ordered');
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
        Schema::dropIfExists('order_items');
    }
}
