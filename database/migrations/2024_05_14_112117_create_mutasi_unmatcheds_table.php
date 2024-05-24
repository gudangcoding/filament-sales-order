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
        Schema::create('mutasi_unmatcheds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->date('tanggal')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('cabang')->nullable();
            $table->decimal('jumlah', 10, 2)->nullable();
            $table->string('type', 3)->nullable();
            $table->decimal('saldo', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_unmatcheds');
    }
};
