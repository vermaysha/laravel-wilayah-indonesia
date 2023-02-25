<?php

use Vermaysha\LaravelWilayahIndonesia\Models\Village;
use Vermaysha\LaravelWilayahIndonesia\Seeds\VillageSeeder;

it('Village has data', function () {
    $this->seed(VillageSeeder::class);

    $village = Village::first();

    expect($village->toArray())->toHaveKeys(['code', 'district_code', 'name', 'created_at', 'updated_at']);
});
