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
        Schema::create('penghapusan_tanahs', function (Blueprint $table) {
            $table->id('id_penghapusan_tanah');
            $table->string('kode_penghapusan_tanah')->unique();
            $table->unsignedBigInteger('id_tanah');
            $table->foreign('id_tanah')->references('id_tanah')->on('tanahs')->onDelete('cascade');
            $table->date('tanggal');
            $table->boolean('status')->default(0);
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

        Schema::dropIfExists('penghapusan_tanahs');
    }
};
