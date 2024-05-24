<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Role;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        "name", "slug"
    ];

    public function members(): BelongsToMany
    {
        return $this->BelongsToMany(User::class);
    }

    public function categories(): HasMany
    {
        return $this->HasMany(Category::class);
    }

    public function role(): HasMany
    {
        return $this->HasMany(Role::class);
    }


    public function produk(): HasMany
    {
        return $this->HasMany(Product::class);
    }
    public function invoice(): HasMany
    {
        return $this->HasMany(Invoice::class);
    }
    public function mutasi_bank(): HasMany
    {
        return $this->HasMany(MutasiBank::class);
    }
    public function customers(): HasMany
    {
        return $this->HasMany(MutasiBank::class);
    }
    public function satuan(): HasMany
    {
        return $this->HasMany(Satuan::class);
    }
    public function supplier(): HasMany
    {
        return $this->HasMany(Supplier::class);
    }
    public function karyawan(): HasMany
    {
        return $this->HasMany(Karyawan::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contacts::class);
    }
    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    public function custumerClass(): HasMany
    {
        return $this->HasMany(CustomerClass::class);
    }
    public function custumerCategory(): HasMany
    {
        return $this->HasMany(CustomerCategory::class);
    }

    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }
    public function salesOrders(): HasMany
    {
        return $this->hasMany(SalesOrder::class);
    }
}
