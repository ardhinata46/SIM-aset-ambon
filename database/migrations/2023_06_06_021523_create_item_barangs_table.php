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
        Schema::create('item_barangs', function (Blueprint $table) {
            $table->id('id_item_barang');
            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')->references('id_barang')->on('barangs')->onDelete('cascade');
            $table->string('kode_item_barang')->unique();
            $table->string('nama_item_barang');
            $table->string('merk')->nullable();
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->enum('sumber', ['pembelian', 'hibah'])->default('pembelian');
            $table->date('tanggal_pengadaan');
            $table->string('harga_perolehan');
            $table->string('umur_manfaat');
            $table->string('nilai_residu');
            $table->integer('nilai_penyusutan')->nullable();
            $table->string('keterangan')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('barangs');
    }
};
