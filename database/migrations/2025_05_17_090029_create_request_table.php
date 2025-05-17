<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('murid_id')->constrained('murids')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->text('pesan');
            $table->enum('status', ['pending', 'ditolak', 'disetujui', 'deal'])->default('pending');
            $table->timestamp('tanggal_request')->useCurrent();
            $table->timestamp('tanggal_deal')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('requests');
    }
};