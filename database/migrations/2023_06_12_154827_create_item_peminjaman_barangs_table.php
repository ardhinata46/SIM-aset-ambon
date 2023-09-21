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
        Schema::create('item_peminjaman_barangs', function (Blueprint $table) {
            $table->id('id_item_peminjaman_barang');
            $table->unsignedBigInteger('id_peminjaman_barang');
            $table->foreign('id_peminjaman_barang')->references('id_peminjaman_barang')->on('peminjaman_barangs')->onDelete('cascade');
            $table->unsignedBigInteger('id_item_barang');
            $table->foreign('id_item_barang')->references('id_item_barang')->on('item_barangs')->onDelete('cascade');
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
        Schema::dropIfExists('item_peminjaman_barangs');
    }
};
