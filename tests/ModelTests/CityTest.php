<?php

use Illuminate\Database\Eloquent\Collection;
use Vermaysha\Wilayah\Models\City;
use Vermaysha\Wilayah\Models\Province;
use Vermaysha\Wilayah\Models\Village;
use Vermaysha\Wilayah\Seeds\CitySeeder;
use Vermaysha\Wilayah\Seeds\DistrictSeeder;
use Vermaysha\Wilayah\Seeds\ProvinceSeeder;
use Vermaysha\Wilayah\Seeds\VillageSeeder;

it('city has data', function () {
    $this->seed(CitySeeder::class);

    $city = City::first();

    expect($city->toArray())->toHaveKeys(['code', 'province_code', 'name', 'created_at', 'updated_at']);
});

it('city has province data', function () {
    $this->seed([
        ProvinceSeeder::class,
        CitySeeder::class,
    ]);

    $city = City::with('province')->first();

    $this->assertInstanceOf(Province::class, $city->province);
});

it('city has many villages data', function () {
    $this->seed([
        CitySeeder::class,
        DistrictSeeder::class,
        VillageSeeder::class,
    ]);

    $city = City::with('villages')->first();

    $this->assertInstanceOf(Collection::class, $city->villages);
    $this->assertInstanceOf(Village::class, $city->villages->first());
});
