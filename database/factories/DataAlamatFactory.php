<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DataAlamat>
 */
class DataAlamatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $teamId = 2;
        return [
            'team_id' => $teamId,
            'user_id' => $user->id,
            'name' => $this->faker->name(),
            'type' => $this->faker->randomElement(['Customer', 'Supplier', 'Karyawan']),
            'no_hp' => $this->faker->phoneNumber(),
            'alamat' => $this->faker->address(),
            'tipe' => $this->faker->randomElement(['Customer', 'Supplier', 'Karyawan']),
            'nama_bank' => $this->faker->company(),
            'no_rekening' => $this->faker->bankAccountNumber(),
            'atas_nama' => $this->faker->name(),
            'nama_toko' => $this->faker->company(),
        ];
    }
}
