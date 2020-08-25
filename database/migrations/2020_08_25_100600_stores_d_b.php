<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StoresDB extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('creator_id');
            $table->string('description')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();

            $table->integer('payment_info_id')->nullable();
            $table->integer('working_times_info_id')->nullable();
            $table->integer('shipping_info_id')->nullable();
            $table->integer('location_info_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
