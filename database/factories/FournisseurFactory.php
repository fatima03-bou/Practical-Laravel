<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fournisseur>
 */
class FournisseurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'raison_social' => $this->faker->name,
            'adresse' => $this->faker->address,
            'tele' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'description' => $this->faker->text(20),
        ];
    }
}
