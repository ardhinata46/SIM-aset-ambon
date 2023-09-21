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
        Schema::create('item_penempatan_barangs', function (Blueprint $table) {
            $table->id('id_item_penempatan_barang');
            $table->unsignedBigInteger('id_penempatan_barang');
            $table->foreign('id_penempatan_barang')->references('id_penempatan_barang')->on('penempatan_barangs')->onDelete('cascade');
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
        Schema::dropIfExists('item_penempatan_barangs');
    }
};
