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
        Schema::create('pengadaan_bangunans', function (Blueprint $table) {
            $table->id('id_pengadaan_bangunan');
            $table->unsignedBigInteger('id_tanah');
            $table->string('kode_pengadaan_bangunan')->unique();
            $table->string('kode_bangunan');
            $table->string('nama_bangunan');
            $table->string('lokasi');
            $table->string('deskripsi');
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->date('tanggal_pengadaan');
            $table->enum('sumber', ['pembangunan', 'pembelian', 'hibah'])->default('pembangunan');
            $table->integer('harga_perolehan');
            $table->integer('umur_manfaat');
            $table->integer('nilai_residu');
            $table->string('nota')->nullable();
            $table->string('keterangan')->nullable();
            $table->tinyInteger('created_by');
            $table->tinyInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('id_tanah')->references('id_tanah')->on('tanahs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengadaan_bangunans');
    }
};
