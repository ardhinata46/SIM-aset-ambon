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
        Schema::create('tanahs', function (Blueprint $table) {
            $table->id('id_tanah');
            $table->string('kode_tanah')->unique();
            $table->string('nama_tanah');
            $table->string('lokasi');
            $table->enum('sumber', ['pembelian', 'hibah']);
            $table->integer('luas');
            $table->date('tanggal_pengadaan');
            $table->integer('harga_perolehan');
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('tanahs');
    }
};
