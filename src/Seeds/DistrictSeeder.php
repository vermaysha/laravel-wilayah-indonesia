<?php

namespace Vermaysha\LaravelWilayahIndonesia\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\LazyCollection;
use Vermaysha\LaravelWilayahIndonesia\Models\District;

class DistrictSeeder extends Seeder
{
    public function run()
    {
        LazyCollection::make(function() {
            $handle = fopen(__DIR__ . '/../../resources/csv/districts.csv', 'r');

            while (($line = fgetcsv($handle, 1000)) !== false) {
                $now = Carbon::now();
                yield [
                    'code'       => $line[0],
                    'city_code'  => $line[1],
                    'name'       => $line[2],
                    'created_at' => $now,
                    'updated_at' => $now
                ];
            }

            fclose($handle);
        })->chunk(1000)->each(function (LazyCollection $chunk) {
            District::insertOrIgnore($chunk->toArray());
        });
    }
}