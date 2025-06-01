<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('agenda_acaras', function (Blueprint $table) {
            $table->id();
            $table->string('asal');
            $table->dateTime('hari_tanggal');
            $table->string('pukul');
            $table->string('acara');
            $table->string('tempat');
            $table->foreignId('surat_id')->constrained('surats')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('agenda_acaras');
    }
};
