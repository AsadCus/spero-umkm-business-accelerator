<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profil_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('alamat')->nullable();
            $table->string('nama_usaha')->nullable();
            $table->string('email_usaha')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('nik')->string();
            $table->string('nib')->string();
            // $table->string('jenis_kelamin');
            $table->enum('jenis_kelamin', ['Pria', 'Perempuan']);
            $table->unsignedBigInteger('provinsi_id');
            $table->unsignedBigInteger('kabupaten_id');
            $table->unsignedBigInteger('kecamatan_id');
            $table->unsignedBigInteger('kelurahan_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_users');
    }
};
