<?php

use Vermaysha\Wilayah\Models\District;
use Vermaysha\Wilayah\Models\Village;
use Vermaysha\Wilayah\Seeds\DistrictSeeder;
use Vermaysha\Wilayah\Seeds\VillageSeeder;

it('village has data', function () {
    $this->seed(VillageSeeder::class);

    $village = Village::first();

    expect($village->toArray())->toHaveKeys(['code', 'district_code', 'name', 'created_at', 'updated_at']);
});

it('village has district data', function () {
    $this->seed([
        DistrictSeeder::class,
        VillageSeeder::class,
    ]);

    $village = Village::with('district')->first();

    $this->assertInstanceOf(District::class, $village->district);
});
