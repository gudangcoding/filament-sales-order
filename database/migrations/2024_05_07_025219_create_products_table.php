<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('gambar_produk')->nullable();
            $table->string('kode_produk')->unique();
            $table->string('nama_produk_cn')->nullable();
            $table->string('nama_produk');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->text('deskripsi')->nullable();
            $table->boolean('aktif')->default(true);
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('ctn')->default(1);
            $table->decimal('price_ctn', 15, 2)->default(1);
            $table->integer('box')->default(1);
            $table->decimal('price_box', 15, 2)->default(1);
            $table->integer('bag')->default(1);
            $table->decimal('price_bag', 15, 2)->default(1);
            $table->integer('card')->default(1);
            $table->decimal('price_card', 15, 2)->default(1);
            $table->integer('lusin')->default(1);
            $table->decimal('price_lsn', 15, 2)->default(1);
            $table->integer('pack')->default(1);
            $table->decimal('price_pack', 15, 2)->default(1);
            $table->integer('pcs')->default(1);
            $table->decimal('price_pcs', 15, 2)->default(1);
            $table->integer('stok')->default(0);
            $table->integer('minimum_stok')->nullable(0);
            $table->integer('jumlah_terjual')->nullable(0);
            $table->decimal('pendapatan_penjualan', 15, 2)->nullable(0);
            $table->integer('jumlah_dibeli')->nullable(0);
            $table->decimal('biaya_pembelian', 15, 2)->nullable(0);
            $table->decimal('bea_masuk', 15, 2)->nullable(0);
            $table->decimal('bea_keluar', 15, 2)->nullable(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}