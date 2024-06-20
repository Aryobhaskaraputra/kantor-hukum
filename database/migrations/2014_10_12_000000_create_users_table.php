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
        Schema::create('users', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('profile_photo_url')->nullable();
            $table->string('nama_depan');
            $table->string('nama_belakang');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('nomor_induk_anggota')->unique();
            $table->string('nomor_induk_kependudukan')->unique()->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('negara')->nullable();
            $table->string('kota_kabupaten')->nullable();
            $table->string('kode_pos')->nullable();
            $table->unsignedBigInteger('role_id')->default(3);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('status')->default('request');
            $table->rememberToken();
            $table->timestamps();

            // Defining foreign key constraint
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
