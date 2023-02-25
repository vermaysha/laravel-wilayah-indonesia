<?php

use Illuminate\Database\Eloquent\Collection;
use Vermaysha\Wilayah\Models\City;
use Vermaysha\Wilayah\Models\District;
use Vermaysha\Wilayah\Models\Province;
use Vermaysha\Wilayah\Seeds\CitySeeder;
use Vermaysha\Wilayah\Seeds\DistrictSeeder;
use Vermaysha\Wilayah\Seeds\ProvinceSeeder;

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
