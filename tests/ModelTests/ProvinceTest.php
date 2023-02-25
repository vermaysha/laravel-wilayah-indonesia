<?php

use Illuminate\Database\Eloquent\Collection;
use Vermaysha\LaravelWilayahID\Models\City;
use Vermaysha\LaravelWilayahID\Models\District;
use Vermaysha\LaravelWilayahID\Models\Province;
use Vermaysha\LaravelWilayahID\Seeds\CitySeeder;
use Vermaysha\LaravelWilayahID\Seeds\DistrictSeeder;
use Vermaysha\LaravelWilayahID\Seeds\ProvinceSeeder;

it('province has data', function () {
    $this->seed(ProvinceSeeder::class);

    $province = Province::first();

    expect($province->toArray())->toHaveKeys(['code', 'name', 'created_at', 'updated_at']);
});

it('province has many cities data', function () {
    $this->seed([
        ProvinceSeeder::class,
        CitySeeder::class,
    ]);

    $province = Province::with('cities')->first();

    $this->assertInstanceOf(Collection::class, $province->cities);
    $this->assertInstanceOf(City::class, $province->cities->first());
});

it('province has many districts data', function () {
    $this->seed([
        ProvinceSeeder::class,
        CitySeeder::class,
        DistrictSeeder::class,
    ]);

    $province = Province::with(['cities', 'districts'])->first();

    $this->assertInstanceOf(Collection::class, $province->districts);
    $this->assertInstanceOf(District::class, $province->districts->first());
});
