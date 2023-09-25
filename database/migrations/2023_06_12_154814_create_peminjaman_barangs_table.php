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
        Schema::create('peminjaman_barangs', function (Blueprint $table) {
            $table->id('id_peminjaman_barang');
            $table->string('kode_peminjaman_barang')->unique();
            $table->date('tanggal');
            $table->boolean('status')->default(0);
            $table->string('nama_peminjam');
            $table->string('kontak');
            $table->string('alamat');
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
        Schema::dropIfExists('peminjaman_barangs');
    }
};
