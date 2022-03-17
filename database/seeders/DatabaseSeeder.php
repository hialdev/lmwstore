<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ProductSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            BrandSeeder::class,
            LabelSeeder::class,
            KategoriSeeder::class,
            KategoriProductSeeder::class,
            //BannerSeeder::class,
            //ValueSeeder::class,
        ]);
    }
}
