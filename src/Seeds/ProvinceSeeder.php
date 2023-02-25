<?php

namespace Vermaysha\LaravelWilayahIndonesia\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\LazyCollection;
use Vermaysha\LaravelWilayahIndonesia\Models\Province;

class ProvinceSeeder extends Seeder
{
    public function run()
    {
        $handle = fopen(__DIR__ . '/../../resources/csv/provinces.csv', 'r');

        $rows = [];
        while (($line = fgetcsv($handle, 1000)) !== false) {
            $now = Carbon::now();
            $rows[] = [
                'code'       => $line[0],
                'name'       => $line[1],
                'created_at' => $now,
                'updated_at' => $now
            ];
        }

        fclose($handle);
        Province::insertOrIgnore($rows);
    }
}