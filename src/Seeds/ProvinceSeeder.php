<?php

namespace Vermaysha\Wilayah\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
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
                'updated_at' => now(),
                'created_at' => now(),
            ]);
        }

        fclose($handle);

        $rows->chunk(1000)->each(function (Collection $row) {
            Province::query()->upsert($row->toArray(), ['code'], ['name', 'updated_at']);
        });
    }
}
