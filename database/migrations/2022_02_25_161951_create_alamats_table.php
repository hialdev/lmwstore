<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlamatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alamats', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->string('tanda');
            $table->string('nama_penerima');
            $table->string('no_penerima');
            $table->string('address');
            $table->string('kota');
            $table->string('provinsi');
            $table->string('zip');
            $table->boolean('priority')->default(false);
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
        Schema::dropIfExists('alamats');
    }
}
