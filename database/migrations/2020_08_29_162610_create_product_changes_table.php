<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_changes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('product_id');
            $table->integer('change-type');
            $table->string('new-title')->nullable();
            $table->string('new-photos')->nullable();
            $table->string('new-description')->nullable();
            $table->double('new-price')->nullable();
            $table->integer('new-currency_id')->nullable();
            $table->integer('new-status')->nullable();
            $table->integer('new-category_id')->nullable();
            $table->string('new-specifications')->nullable();
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
        Schema::dropIfExists('product_changes');
    }
}
