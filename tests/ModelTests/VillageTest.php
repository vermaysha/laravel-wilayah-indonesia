<?php

use Vermaysha\LaravelWilayahID\Models\District;
use Vermaysha\LaravelWilayahID\Models\Village;
use Vermaysha\LaravelWilayahID\Seeds\DistrictSeeder;
use Vermaysha\LaravelWilayahID\Seeds\VillageSeeder;

it('village has data', function () {
    $this->seed(VillageSeeder::class);

    $village = Village::first();

    expect($village->toArray())->toHaveKeys(['code', 'district_code', 'name', 'created_at', 'updated_at']);
});

it('village has district data', function () {
    $this->seed([
        DistrictSeeder::class,
        VillageSeeder::class
    ]);

    $village = Village::with('district')->first();

    $this->assertInstanceOf(District::class, $village->district);
});
