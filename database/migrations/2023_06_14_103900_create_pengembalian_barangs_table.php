<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengembalian_barangs', function (Blueprint $table) {
            $table->id('id_pengembalian_barang');
            $table->string('kode_pengembalian_barang');
            $table->unsignedBigInteger('id_peminjaman_barang');
            $table->date('tanggal');
            $table->boolean('status')->default(1);
            $table->string('keterangan')->nullable();;
            $table->tinyInteger('created_by');
            $table->tinyInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('id_peminjaman_barang')->references('id_peminjaman_barang')->on('peminjaman_barangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengembalian_barangs');
    }
};
