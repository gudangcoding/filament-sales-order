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
        Schema::create('pengirimans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('team_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('sales_order_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('jenis_kirim')->nullable();
            $table->string('nama_ekspedisi')->nullable();
            $table->string('via')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('plat_mobil')->nullable();
            $table->string('sopir')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('nama_toko')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengirimans');
    }
};
