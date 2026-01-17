<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['Hadir', 'Telat', 'Izin', 'Sakit', 'Alfa']);
            $table->time('jam_datang')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('bukti')->nullable();
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])
                ->default('pending');

            $table->text('approval_note')->nullable();
            $table->timestamps();
            $table->unique(['guru_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
