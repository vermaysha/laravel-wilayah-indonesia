<?php

namespace Vermaysha\LaravelWilayahIndonesia\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(ProvinceSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(VillageSeeder::class);
    }
}
