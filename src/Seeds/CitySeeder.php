<?php

namespace Vermaysha\LaravelWilayahIndonesia\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\LazyCollection;
use Vermaysha\LaravelWilayahIndonesia\Models\City;

class CitySeeder extends Seeder
{
    public function run()
    {
        LazyCollection::make(function() {
            $handle = fopen(__DIR__ . '/../../resources/csv/cities.csv', 'r');

            while (($line = fgetcsv($handle, 1000)) !== false) {
                $now = Carbon::now();
                yield [
                    'code'          => $line[0],
                    'province_code' => $line[1],
                    'name'          => $line[2],
                    'created_at'    => $now,
                    'updated_at'    => $now
                ];
            }

            fclose($handle);
        })->chunk(1000)->each(function (LazyCollection $chunk) {
            City::insertOrIgnore($chunk->toArray());
        });
    }
}
