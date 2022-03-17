<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class KategoriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->sentence(1);
        return [
            'name' => $name,
            'icon' => $this->faker->sentence(1),
            'slug' => Str::slug($name),
        ];
    }
}
