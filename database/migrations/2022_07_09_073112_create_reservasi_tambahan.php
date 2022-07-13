<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasiTambahan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservasi_tambahan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('reservasi_id')->unsigned()->nullable();
            $table->bigInteger('layanan_id')->unsigned();
            $table->integer('harga');
            $table->timestamps();
            $table->foreign('reservasi_id')->references('id')->on('penerimaan-reservasi');
            $table->foreign('layanan_id')->references('id')->on('layanan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservasi_tambahan');
    }
}
