<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $elemwe = 'ELEMWE';
        Brand::create([
            'name' => $elemwe,
            'image' => '/assets/images/elemwe-logo.png',
            'slug' => Str::slug($elemwe),
        ]);

        $tambora = 'Batik Tambora';
        Brand::create([
            'name' => $tambora,
            'image' => '/assets/images/btk-tambora-logo.jpeg',
            'slug' => Str::slug($tambora),
        ]);
    }
}
