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
            $table->increments('id');
            $table->string('name');
            $table->bigInteger('sku');
            $table->boolean('status')->nullable();
            $table->float('base_price');
            $table->integer('individual_discount')->nullable();
            $table->string('image');
            $table->longText('description');
            $table->float('post_tax_price')->nullable();
            $table->float('consumer_price')->nullable();
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
