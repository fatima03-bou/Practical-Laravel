<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\fournisseur;
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
        return [
            'name' => $this->faker->word(),
            "description" => $this->faker->sentence(),
            "image" => "1.jpg",
            'price' => $this->faker->randomFloat(2, 10, 100),
            'quantity_store' => $this->faker->numberBetween(0, 15),
            'category_id' => Category::inRandomOrder()->first()->id ?? 1,
            'fournisseur_id' => fournisseur::inRandomOrder()->first()->id ?? 1, 
            

        ];
    }
}
