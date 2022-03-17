<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KategoriProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_product' => $this->faker->numberBetween(1,4),
            'id_kategori' => $this->faker->numberBetween(1,4),
        ];
    }
}
