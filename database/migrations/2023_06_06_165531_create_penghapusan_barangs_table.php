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
        Schema::create('penghapusan_barangs', function (Blueprint $table) {
            $table->id('id_penghapusan_barang');
            $table->string('kode_penghapusan_barang')->unique();
            $table->unsignedBigInteger('id_item_barang');
            $table->foreign('id_item_barang')->references('id_item_barang')->on('item_barangs')->onDelete('cascade');
            $table->date('tanggal');
            $table->boolean('status')->default(0);
            $table->enum('alasan', ['rusak', 'hilang', 'tidak_digunakan'])->default('rusak');
            $table->enum('tindakan', ['jual', 'hibah', 'dihanguskan'])->default('jual');
            $table->integer('harga')->nullable();
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
        Schema::dropIfExists('penghapusan_barangs');
    }
};
