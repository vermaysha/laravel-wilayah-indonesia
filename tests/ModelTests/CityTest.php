<?php

use Illuminate\Database\Eloquent\Collection;
use Vermaysha\LaravelWilayahID\Models\City;
use Vermaysha\LaravelWilayahID\Models\Province;
use Vermaysha\LaravelWilayahID\Models\Village;
use Vermaysha\LaravelWilayahID\Seeds\CitySeeder;
use Vermaysha\LaravelWilayahID\Seeds\DistrictSeeder;
use Vermaysha\LaravelWilayahID\Seeds\ProvinceSeeder;
use Vermaysha\LaravelWilayahID\Seeds\VillageSeeder;

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
