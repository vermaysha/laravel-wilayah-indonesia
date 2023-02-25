<?php

namespace Vermaysha\LaravelWilayahID\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\LazyCollection;
use Vermaysha\LaravelWilayahID\Models\City;

class CitySeeder extends Seeder
{
    public function run()
    {
        LazyCollection::make(function () {
            $handle = fopen(__DIR__.'/../../resources/csv/cities.csv', 'r');

            while (($line = fgetcsv($handle, 4096)) !== false) {
                $now = Carbon::now();
                yield [
                    'code' => $line[0],
                    'province_code' => $line[1],
                    'name' => $line[2],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                if (app()->runningUnitTests()) break;
            }

            fclose($handle);
        })->chunk(1000)->each(function (LazyCollection $chunk) {
            City::insertOrIgnore($chunk->toArray());
        });
    }
}
