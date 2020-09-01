<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookShoppingCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_shopping_cart', function (Blueprint $table) {
            $table->unsignedBigInteger('shopping_cart_id');
            $table->unsignedBigInteger('book_id');
            $table->integer('quantity');
            $table->float('unit_price');

            $table->foreign('shopping_cart_id')->references('id')->on('shopping_carts');
            $table->foreign('book_id')->references('id')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopping_cart_detail');
    }
}
