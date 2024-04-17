<?php

namespace Vermaysha\Wilayah\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\LazyCollection;
use Vermaysha\Wilayah\Models\Village;

class VillageSeeder extends Seeder
{
    public function run()
    {
        LazyCollection::make(function () {
            $handle = fopen(__DIR__.'/../../resources/csv/villages.csv', 'r');

            while (($line = fgetcsv($handle, 4096)) !== false) {
                yield [
                    'code' => $line[0],
                    'district_code' => $line[1],
                    'name' => $line[2],
                ];

                if (app()->runningUnitTests()) {
                    break;
                }
            }

            fclose($handle);
        })->each(function (array $row) {
            Village::updateOrInsert(['code' => $row['code']], $row);
        });
    }
}
