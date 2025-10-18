<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Jurusan;

class KelasFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_jurusan' => $this->faker->numberBetween(1, 5),
            'tingkat_kelas' => $this->faker->randomElement(['10', '11', '12']),
            'nama_kelas' => $this->faker->randomElement(['X PPLG 1', 'X MBPLB 1', 'XI PPLG 2']),
        ];
    }
}
