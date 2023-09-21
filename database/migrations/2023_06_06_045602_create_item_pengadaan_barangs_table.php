<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return voidk
     */
    public function up()
    {
        Schema::create('item_pengadaan_barangs', function (Blueprint $table) {
            $table->id('id_item_pengadaan_barang');
            $table->unsignedBigInteger('id_pengadaan_barang');
            $table->foreign('id_pengadaan_barang')->references('id_pengadaan_barang')->on('pengadaan_barangs')->onDelete('cascade');
            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')->references('id_barang')->on('barangs')->onDelete('cascade');
            $table->string('nama_item_barang');
            $table->string('merk')->nullable();
            $table->integer('harga_perolehan');
            $table->integer('umur_manfaat');
            $table->integer('nilai_residu');
            $table->integer('jumlah');
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
        Schema::dropIfExists('item_pengadaan_barangs');
    }
};
