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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_order_id')->nullable()->constrained();
            $table->date('tanggal')->nullable();
            $table->decimal('jumlah_hutang', 18, 2)->nullable();
            $table->decimal('jumlah_bayar', 18, 2)->nullable();
            $table->decimal('sisa', 18, 2)->nullable();
            $table->string('bukti_bayar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
