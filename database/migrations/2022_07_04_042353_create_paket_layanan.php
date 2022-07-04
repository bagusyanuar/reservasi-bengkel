<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketLayanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_layanan', function (Blueprint $table) {
            $table->primary(['paket_id', 'layanan_id']);
            $table->bigInteger('paket_id')->unsigned();
            $table->bigInteger('layanan_id')->unsigned();
            $table->foreign('layanan_id')->references('id')->on('layanan');
            $table->foreign('paket_id')->references('id')->on('paket');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paket_layanan');
    }
}
