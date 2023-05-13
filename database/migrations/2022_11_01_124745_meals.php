<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->string('id')->nullable(false)->primary();
            $table->string('restaurant_id')->nullable(false);
            $table->string('category_id')->nullable();
            $table->float('price');
            $table->string('weight')->nullable();
            $table->string('name')->nullable(false);
            $table->text('image');
            $table->string('restaurant_name');
            $table->string('category_name');
            $table->timestamps();
            $table->foreign('restaurant_id')->references('id')->on('restaurants');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meals');
    }
};
