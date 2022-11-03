<?php

namespace Database\Seeders;

use App\Models\Family;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(PopulationSeeder::class);
        $this->call(FamilySeeder::class);

    }
}
