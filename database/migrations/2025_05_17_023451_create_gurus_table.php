<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('keahlian');
            $table->string('lokasi');
            $table->string('foto_profile');
            $table->string('foto_sertifikat');
            $table->string('foto_ktp');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('gurus');
    }
};

