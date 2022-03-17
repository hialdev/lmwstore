<?php

namespace Database\Seeders;

use App\Models\KategoriProduct;
use Illuminate\Database\Seeder;

class KategoriProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KategoriProduct::factory(32)->create();
    }
}
