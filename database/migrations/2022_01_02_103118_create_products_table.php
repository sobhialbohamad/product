<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
          $table->Increments('id');
          $table->string('name');
          $table->string('image_url')->nullable();
          $table->string('category');
          $table->text('phone');
          $table->integer('quantity');
          $table->string('quantity_type');
          $table->integer('price');
          $table->integer('priceAfterdiscount');
          $table->integer('view_number');
          $table->boolean('product_active');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
