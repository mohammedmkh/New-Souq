<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->integer('category_id');
            $table->integer('store_id');
            $table->integer('creator_id');
            $table->integer('status');
            $table->decimal('price', 15, 2)->nullable();
            $table->integer('currency_id');
            $table->integer('quantity');
            $table->integer('sold-quantity');
            $table->integer('max-quantity-perOrder');
            $table->string('images');
            $table->string('specifications');
            $table->integer('ratings-sum');
            $table->integer('ratings-count');
            $table->boolean('approved-by-admins');
            $table->integer('approved-by-admin_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
