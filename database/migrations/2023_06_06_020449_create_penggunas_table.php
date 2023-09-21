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
        Schema::create('penggunas', function (Blueprint $table) {
            $table->id('id_pengguna');
            $table->string('nama_pengguna');
            $table->enum('role', ['superadmin', 'admin'])->default('admin');
            $table->enum('jk', ['l', 'p'])->default('l');
            $table->string('email')->unique();
            $table->string('password')->default('123456');
            $table->string('alamat');
            $table->string('kontak');
            $table->boolean('status')->default(1);
            $table->string('remember_token')->nullable();
            $table->string('foto')->nullable()->default('image.png');
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
        Schema::dropIfExists('penggunas');
    }
};
