<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'book_order',
            function (Blueprint $table) {
                $table->unsignedBigInteger('order_id');
                $table->unsignedBigInteger('book_id');
                $table->integer('quantity');
                $table->float('unit_price');

                $table->primary(['book_id', 'order_id']);
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
                $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            }
        );
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
