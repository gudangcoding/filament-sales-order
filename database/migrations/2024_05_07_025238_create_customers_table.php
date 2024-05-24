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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('kode_customer')->nullable()->unique();
            $table->foreignId('team_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('customer_class_id')->nullable()->constrained();
            $table->foreignId('customer_category_id')->nullable()->constrained();
            $table->string('nama_customer');
            $table->string('daerah_customer')->nullable();
            $table->decimal('sisa_limit_hutang', 10, 2)->default(0);
            $table->decimal('total_hutang', 10, 2)->default(0);
            $table->decimal('hutang_dlm_tempo', 10, 2)->default(0);
            $table->decimal('hutang_lewat_tempo', 10, 2)->default(0);
            $table->decimal('limit_nota', 10, 2)->default(0);
            $table->decimal('limit_hutang', 10, 2)->default(0);
            $table->string('catatan')->nullable();
            $table->string('jenis_badan_usaha')->nullable();
            $table->string('tgl_beli')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
