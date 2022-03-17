<?php

namespace Database\Seeders;

use App\Models\Value;
use Illuminate\Database\Seeder;

class ValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Value::factory(3)->create();
    }
}
