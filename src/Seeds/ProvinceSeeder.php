<?php

namespace Vermaysha\Wilayah\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Vermaysha\Wilayah\Models\Province;

class ProvinceSeeder extends Seeder
{
    public function run()
    {
        $handle = fopen(__DIR__.'/../../resources/csv/provinces.csv', 'r');

        $rows = collect();
        while (($line = fgetcsv($handle)) !== false) {
            $rows->push([
                'code' => $line[0],
                'name' => $line[1],
            ]);
        }

        fclose($handle);


        $rows->each(function (array $row) {
            Province::updateOrInsert(['code' => $row['code']], $row);
        });
    }
}
