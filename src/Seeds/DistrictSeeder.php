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
                ];

                if (app()->runningUnitTests()) {
                    break;
                }
            }

            fclose($handle);
        })->each(function (array $row) {
            District::updateOrInsert(['code' => $row['code']], $row);
        });
    }
}
