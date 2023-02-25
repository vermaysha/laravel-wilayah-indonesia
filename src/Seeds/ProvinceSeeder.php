<?php

namespace Vermaysha\LaravelWilayahID\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Vermaysha\LaravelWilayahID\Models\Province;

class ProvinceSeeder extends Seeder
{
    public function run()
    {
        $handle = fopen(__DIR__.'/../../resources/csv/provinces.csv', 'r');

        $rows = [];
        while (($line = fgetcsv($handle)) !== false) {
            $now = Carbon::now();
            $rows[] = [
                'code' => $line[0],
                'name' => $line[1],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        fclose($handle);
        Province::insertOrIgnore($rows);
    }
}
