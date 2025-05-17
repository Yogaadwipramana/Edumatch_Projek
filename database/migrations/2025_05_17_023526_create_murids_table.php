<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('murids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('bidang_pelatihan');
            $table->string('lokasi');
            $table->string('file_identitas');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('murids');
    }
};

