<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChitietGiayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chitiet_giay', function (Blueprint $table) {
            $table->increments('id_chitiet_giay');
            $table->unsignedInteger('id_giay');
            $table->string('size');
            $table->integer('so_luong')->default(0);
            
            $table->foreign('id_giay')->references('id_giay')->on('giay')->onDelete('cascade');
            $table->index('id_giay');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chitiet_giay');
    }
}
