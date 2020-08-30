<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTitlePhotosModificationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_title_photos_modification_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('datetime');
            $table->integer('product_id');
            $table->string('title');
            $table->string('photos');
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
        Schema::dropIfExists('product_title_photos_modification_requests');
    }
}
