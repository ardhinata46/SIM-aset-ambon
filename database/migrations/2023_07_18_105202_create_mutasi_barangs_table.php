<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutasi_barangs', function (Blueprint $table) {
            $table->id('id_mutasi_barang');
            $table->string('kode_mutasi_barang')->unique();
            $table->unsignedBigInteger('id_item_barang');
            $table->foreign('id_item_barang')->references('id_item_barang')->on('item_barangs')->onDelete('cascade');
            $table->unsignedBigInteger('id_ruangan_awal');
            $table->foreign('id_ruangan_awal')->references('id_ruangan')->on('ruangans')->onDelete('cascade');
            $table->unsignedBigInteger('id_ruangan_tujuan');
            $table->foreign('id_ruangan_tujuan')->references('id_ruangan')->on('ruangans')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('keterangan')->nullable();
            $table->tinyInteger('created_by');
            $table->tinyInteger('updated_by')->nullable();
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
        Schema::dropIfExists('mutasi_barangs');
    }
};
