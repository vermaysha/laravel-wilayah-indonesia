<?php

use Illuminate\Database\Eloquent\Collection;
use Vermaysha\LaravelWilayahID\Models\City;
use Vermaysha\LaravelWilayahID\Models\District;
use Vermaysha\LaravelWilayahID\Models\Village;
use Vermaysha\LaravelWilayahID\Seeds\CitySeeder;
use Vermaysha\LaravelWilayahID\Seeds\DistrictSeeder;
use Vermaysha\LaravelWilayahID\Seeds\VillageSeeder;

it('district has data', function () {
    $this->seed(DistrictSeeder::class);

    $district = District::first();

    expect($district->toArray())->toHaveKeys(['code', 'city_code', 'name', 'created_at', 'updated_at']);
});

it('district has city data', function () {
    $this->seed([
        CitySeeder::class,
        DistrictSeeder::class,
    ]);

    $district = District::with('city')->first();

    $this->assertInstanceOf(City::class, $district->city);
});

it('district has many villages data', function () {
    $this->seed([
        DistrictSeeder::class,
        VillageSeeder::class
    ]);

    $district = District::with('villages')->first();

    $this->assertInstanceOf(Collection::class, $district->villages);
    $this->assertInstanceOf(Village::class, $district->villages->first());
});
