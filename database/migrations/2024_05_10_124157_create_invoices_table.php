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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('order_number')->nullable();
            $table->string('status')->nullable();
            $table->string('type_bayar')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tempo')->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->decimal('dp', 10, 2)->nullable();
            $table->decimal('sisa', 10, 2)->nullable();
            $table->decimal('kembali', 10, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('invoice_details', function (Blueprint $table) {
            $table->uuid();
            $table->foreignId('invoice_id')->nullable()->constrained();
            $table->integer('total_qty')->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('invoices_detail');
    }
};
