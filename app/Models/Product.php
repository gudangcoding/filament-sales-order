<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = [
        'gambar_produk',
        'kode_produk',
        'nama_produk_cn',
        'nama_produk',
        'category_id',
        'deskripsi',
        'aktif',
        'team_id',
        'user_id',
        'ctn',
        'price_ctn',
        'box',
        'price_box',
        'bag',
        'price_bag',
        'card',
        'price_card',
        'lusin',
        'price_lsn',
        'pack',
        'price_pack',
        'pcs',
        'price_pcs',
        'stok',
        'minimum_stok',
        'jumlah_terjual',
        'pendapatan_penjualan',
        'jumlah_dibeli',
        'biaya_pembelian',
        'bea_masuk',
        'bea_keluar'
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Team::class);
    }

    public function ProductVariant()
    {
        return $this->hasMany(\App\Models\ProductVariant::class);
    }

    public function scopeActive($query)
    {
        return $query->where('aktif', true);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product')
            ->useDisk('public');
    }
}
