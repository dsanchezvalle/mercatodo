<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'books', function (Blueprint $table) {
                $table->id();
                $table->string('isbn')->unique();
                $table->string('title');
                $table->string('author');
                $table->integer('price');
                $table->smallInteger('stock');
                $table->string('image_path');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
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
        Schema::dropIfExists('books');
    }
}
