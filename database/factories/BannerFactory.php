<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $position = ['banner-content-center','banner-content-right',''];
        $images = ['banner-1','banner-2','banner-3','banner-4','banner-5'];

        return [
            'title' => $this->faker->sentence(3),
            'sub_title' => $this->faker->sentence(1),
            'image' => '/assets/images/demos/demo-7/banners/'.$images[array_rand($images)].'.jpg',
            'position' => $position[array_rand($position)],
            'featured' => $this->faker->boolean(2),
            'btn_text' => 'SHOP NOW',
            'btn_url' => 'shop',
        ];
    }
}
