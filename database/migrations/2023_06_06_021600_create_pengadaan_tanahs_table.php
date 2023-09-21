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
        Schema::create('pengadaan_tanahs', function (Blueprint $table) {
            $table->id('id_pengadaan_tanah');
            $table->string('kode_pengadaan_tanah')->unique();
            $table->string('kode_tanah')->unique();
            $table->string('nama_tanah');
            $table->string('lokasi');
            $table->date('tanggal_pengadaan');
            $table->enum('sumber', ['pembelian', 'hibah'])->default('pembelian');
            $table->integer('harga_perolehan');
            $table->integer('luas');
            $table->string('nota')->nullable();
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
        Schema::dropIfExists('pengadaan_tanahs');
    }
};
