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
        Schema::create('pengadaan_barangs', function (Blueprint $table) {
            $table->id('id_pengadaan_barang');
            $table->string('kode_pengadaan_barang')->unique();
            $table->date('tanggal_pengadaan');
            $table->enum('sumber', ['pembangunan', 'pembelian', 'hibah'])->default('pembangunan');
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
        Schema::dropIfExists('pengadaan_barangs');
    }
};
