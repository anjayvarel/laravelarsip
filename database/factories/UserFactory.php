<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(), // HARUS 'nama' bukan 'name'
            'nip' => $this->faker->numerify('######'), // 6 digit random
            'password' => Hash::make('password'), // Hash password
            'role' => $this->faker->randomElement(['admin', 'staff']), // Random role
        ];
    }
}
