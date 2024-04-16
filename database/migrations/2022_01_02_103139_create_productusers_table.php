<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productusers', function (Blueprint $table) {
          $table->Increments('id');
          $table->integer('user_id')->unsigned();
          $table->integer('product_id')->unsigned();
          $table->date('expiry_date')->format('d/m/y');
          $table->foreign('user_id')->references('id')->on('users');
          $table->foreign('product_id')->references('id')->on('products');
          $table->timestamps()->format('d/m/y');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productusers');
    }
}
