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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('so_no')->nullable()->unique();
            $table->foreignId('team_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('customer_id')->nullable()->constrained();
            $table->string('customer_class_id')->nullable()->constrained();
            $table->string('customer_category_id')->nullable()->constrained();
            $table->decimal('subtotal', 8, 2)->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('diskon', 18, 2)->nullable();
            $table->decimal('ongkir', 18, 2)->nullable();
            $table->decimal('grand_total', 18, 2)->nullable();
            $table->date('tanggal')->nullable();
            $table->timestamps();
        });
        Schema::create('sales_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_order_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('satuan')->nullable();
            $table->decimal('harga', 16, 2)->nullable();
            $table->integer('qty')->nullable();
            $table->integer('koli')->nullable();
            $table->integer('jumlah_koli')->nullable()->default(1);
            $table->decimal('subtotal', 16, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_detail');
        Schema::dropIfExists('sales_orders');
    }
};
