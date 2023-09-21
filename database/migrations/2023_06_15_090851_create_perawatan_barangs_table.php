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
        Schema::create('perawatan_barangs', function (Blueprint $table) {
            $table->id('id_perawatan_barang');
            $table->string('kode_perawatan_barang')->unique();
            $table->unsignedBigInteger('id_item_barang');
            $table->foreign('id_item_barang')->references('id_item_barang')->on('item_barangs')->onDelete('cascade');
            $table->date('tanggal_perawatan');
            $table->string('kondisi_sebelum');
            $table->enum('kondisi_sesudah', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->string('deskripsi');
            $table->integer('biaya')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('nota')->nullable();
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
        Schema::dropIfExists('perawatan_barangs');
    }
};
