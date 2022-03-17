<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'desc' => $this->faker->paragraph(1),
            'icon' => 'akar-icons:circle-check',
        ];
    }
}
