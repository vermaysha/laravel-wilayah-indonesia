<?php

use Vermaysha\LaravelWilayahIndonesia\Models\Province;
use Vermaysha\LaravelWilayahIndonesia\Seeds\ProvinceSeeder;

it('province has data', function () {
    $this->seed(ProvinceSeeder::class);

    $province = Province::first();

    expect($province->toArray())->toHaveKeys(['code', 'name', 'created_at', 'updated_at']);
});
