<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->integer('id_brand');
            $table->integer('id_label')->nullable();
            $table->string('name');
            $table->text('image');
            $table->string('brief');
            $table->integer('price');
            $table->integer('discount')->nullable()->default(0);
            $table->text('desc');
            $table->integer('stock');
            $table->boolean('preorder')->default(false);
            $table->string('size')->nullable();
            $table->string('variant')->nullable();
            $table->string('slug');
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
        Schema::dropIfExists('products');
    }
}
