<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_surat', ['masuk', 'keluar']);
            $table->string('no_surat');
            $table->string('pengirim');
            $table->string('no_agenda')->nullable();
            $table->date('tanggal_surat');
            $table->date('tanggal_diterima');
            $table->string('perihal');
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->string('lampiran')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('surats');
    }
};
