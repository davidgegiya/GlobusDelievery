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
        Schema::create('users', function (Blueprint $table) {
            $table->string('id')->nullable(false)->primary();
            $table->string('email')->nullable(false)->unique('email');
            $table->string('password')->nullable(false);
            $table->string('current_order')->nullable();
            $table->rememberToken();
            $table->string('phone');
            $table->string('username');
            $table->string('address');
            $table->timestamps();
//            $table->foreign('current_order')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
