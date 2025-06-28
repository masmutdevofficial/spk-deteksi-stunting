<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        // Tabel users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('username', 255)->unique();
            $table->string('password', 255);
            $table->tinyInteger('level')->comment('1=Tenaga Medis, 2=Admin');
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Tabel data_bayi
        Schema::create('data_bayi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('nama', 255);
            $table->string('umur', 255);
            $table->tinyInteger('jenis_kelamin')->comment('1=L, 2=P');
            $table->decimal('berat', 5, 2);
            $table->decimal('tinggi', 5, 2);
            $table->decimal('lila', 5, 2);
            $table->decimal('nilai_bb_tb', 5, 2);
            $table->string('hasil_bb_tb', 255);
            $table->timestamps();
        });

        // Tabel jadwal_kegiatan
        Schema::create('jadwal_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('bulan', 255);
            $table->string('kegiatan', 255);
            $table->string('sasaran', 255);
            $table->string('pelaksana', 255);
            $table->text('catatan_tambahan');
            $table->timestamps();
        });

        // Tabel jadwal_penimbangan
        Schema::create('jadwal_penimbangan', function (Blueprint $table) {
            $table->id();
            $table->string('bulan', 255);
            $table->string('lokasi_posyandu', 255);
            $table->date('tanggal_penimbangan');
            $table->string('waktu', 255);
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('jadwal_penimbangan');
        Schema::dropIfExists('jadwal_kegiatan');
        Schema::dropIfExists('data_bayi');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
