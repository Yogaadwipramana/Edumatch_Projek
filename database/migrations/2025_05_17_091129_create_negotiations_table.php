<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('negotiations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('requests')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('pesan');
            $table->decimal('harga', 10, 2)->nullable();
            $table->timestamp('waktu_pelaksanaan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('negotiations');
    }
};