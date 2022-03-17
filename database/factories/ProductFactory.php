<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $images = ['product-1','product-2','product-3','product-4','product-5','product-6','product-7','product-8','product-9','product-10','product-11','product-12','product-13'];
        $img = [];
        for ($i=0; $i < 4; $i++) { 
            $img[] = '/assets/images/products/'.$images[array_rand($images)].'.jpg';
        }
        $img = json_encode($img);
        
        $size = json_encode(['L','M','XL']);
        $variant = json_encode(['Hitam Stripped','Cream Stripped','Hitam Original','Cream Original']);
        $name = $this->faker->sentence(6);

        return [
            'id_brand' => $this->faker->numberBetween(1,2),
            'id_label' => $this->faker->numberBetween(1,5),
            'name' => $name,
            'image' => $img,
            'brief' => $this->faker->sentence(20),
            'price' => $this->faker->numberBetween(100000,999999),
            'discount' => $this->faker->numberBetween(0,99),
            'stock' => $this->faker->numberBetween(3,49),
            'desc' => $this->faker->paragraph(5),
            'size' => $size,
            'variant' => $variant,
            'slug' => Str::slug($name),
        ];
    }
}
