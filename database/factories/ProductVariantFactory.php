<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'gambar' => $this->faker->imageUrl(),
            'harga' => $this->faker->randomNumber(4),
            'satuan' => $this->faker->randomElement(['Pcs', 'Kg', 'Meter']),
            'ukuran_kemasan' => $this->faker->randomNumber(2),
            'isi' => $this->faker->randomNumber(3),
            'stok' => $this->faker->randomNumber(2),
        ];
    }
}
