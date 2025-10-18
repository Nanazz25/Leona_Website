<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class GuruFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'nip' => $this->faker->unique()->numerify('1987#########'),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
        ];
    }
}
