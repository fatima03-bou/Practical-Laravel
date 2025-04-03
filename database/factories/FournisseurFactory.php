<?php

namespace Database\Factories;

use App\Models\Fournisseur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fournisseur>
 */
class FournisseurFactory extends Factory
{
    protected $model = Fournisseur::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'raison_social' => $this->faker->company,
            'adresse' => $this->faker->address,           
            'tele' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'description' => $this->faker->text(200),

        ];
    }
}
