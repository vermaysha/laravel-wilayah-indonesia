<?php

namespace Vermaysha\Wilayah\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\LazyCollection;
use Vermaysha\Wilayah\Models\District;

class DistrictSeeder extends Seeder
{
    public function run()
    {
        LazyCollection::make(function () {
            $handle = fopen(__DIR__.'/../../resources/csv/districts.csv', 'r');

            while (($line = fgetcsv($handle, 4096)) !== false) {
                yield [
                    'code' => $line[0],
                    'city_code' => $line[1],
                    'name' => $line[2],
                    'updated_at' => now(),
                    'created_at' => now(),
                ];

                if (app()->runningUnitTests()) {
                    break;
                }
            }

            fclose($handle);
        })->chunk(1000)->each(function (LazyCollection $row) {
            District::query()->upsert($row->toArray(), ['code'], ['name', 'updated_at']);
        });
    }
}
