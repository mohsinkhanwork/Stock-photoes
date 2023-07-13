<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreignId('sub_category_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('description')->nullable();
            $table->string('title')->nullable();
            $table->string('EK_year')->nullable();
            $table->string('image_year')->nullable();
            $table->string('OF_height')->nullable();
            $table->string('OF_width')->nullable();
            $table->string('weather')->nullable();
            $table->string('season')->nullable();
            $table->string('original_filename')->nullable();
            $table->string('status')->nullable();
            $table->string('photographer')->nullable();
            $table->string('image')->nullable();
            $table->string('small_thumbnail')->nullable();
            $table->string('singleImage')->nullable();
            $table->string('original_image')->nullable();
            $table->string('originalResized')->nullable();
            $table->integer('EK_price')->nullable();
            $table->string('color_create_version')->nullable();
            $table->string('image_name')->nullable();
            $table->integer('counter')->nullable();
            $table->string('type')->nullable();
            $table->string('category_id_2')->nullable();
            $table->string('sub_category_id_2')->nullable();
            $table->string('category_id_3')->nullable();
            $table->string('sub_category_id_3')->nullable();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('photos');
    }
}
