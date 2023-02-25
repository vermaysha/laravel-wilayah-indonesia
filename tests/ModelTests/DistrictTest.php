<?php

use Vermaysha\LaravelWilayahIndonesia\Models\District;
use Vermaysha\LaravelWilayahIndonesia\Seeds\DistrictSeeder;

it('district has data', function () {
    $this->seed(DistrictSeeder::class);

    $district = District::first();

    expect($district->toArray())->toHaveKeys(['code', 'city_code', 'name', 'created_at', 'updated_at']);
});
