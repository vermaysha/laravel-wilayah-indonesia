<?php

use Vermaysha\LaravelWilayahID\Models\City;
use Vermaysha\LaravelWilayahID\Seeds\CitySeeder;

it('city has data', function () {
    $this->seed(CitySeeder::class);

    $city = City::first();

    expect($city->toArray())->toHaveKeys(['code', 'province_code', 'name', 'created_at', 'updated_at']);
});
