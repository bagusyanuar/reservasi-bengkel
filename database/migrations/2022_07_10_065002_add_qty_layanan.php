<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQtyLayanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservasi_tambahan', function (Blueprint $table) {
            $table->integer('qty')->after('layanan_id')->default(0);
            $table->integer('total')->after('harga')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservasi_tambahan', function (Blueprint $table) {
            $table->dropColumn('qty');
            $table->dropColumn('total');
        });
    }
}
