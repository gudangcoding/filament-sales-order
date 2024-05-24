<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $category = Category::inRandomOrder()->first();
        $teamId = 2;
        return [
            'team_id' => $teamId,
            'user_id' => $user->id,
            'category_id' => $category->id,
            'name' => $this->faker->word(),
            'format_satuan' => $this->faker->randomElement(['Pcs', 'Kg', 'Meter']),
            'slug' => $this->faker->slug(),
            'deskripsi' => $this->faker->word(),
        ];
    }
}
