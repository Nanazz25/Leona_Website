<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'username' => $this->faker->name(),
            'password' => bcrypt('password'),
            'role' => $this->faker->randomElement(['kurikulum', 'guru', 'murid']),
            'role_id' => null,
        ];
    }
}
