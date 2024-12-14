<?php

namespace Vermaysha\Territory\Tests\Traits;

use Illuminate\Support\Facades\DB;
use Vermaysha\Territory\Models\District;
use Vermaysha\Territory\Models\Province;
use Vermaysha\Territory\Models\Regency;
use Vermaysha\Territory\Models\Village;

trait ModelTestTrait
{
    protected function db()
    {
        return DB::connection(config('terrytory_id.connection', config('database.default')));
    }

    /**
     * Setup the test environment.
     *
     * This method is called before each test is executed.
     */
    protected function setUp(): void
    {
        parent::setUp();
        config(['cache.default' => 'array']);

        $this->loadMigrationsFrom(__DIR__.'/../../databases/migrations');

        $this->db()->table((new Province())->getTable())->insert([
            'province_code' => '33',
            'province_name' => 'Jawa Tengah',
        ]);

        $this->db()->table((new Regency)->getTable())->insert([
            'regency_code' => '13',
            'regency_name' => 'Kabupaten Karanganyar',
            'province_code' => '33',
        ]);

        $this->db()->table((new District())->getTable())->insert([
            'district_code' => '15',
            'district_name' => 'Kecamatan Mojogedang',
            'regency_code' => '13',
            'province_code' => '33',
        ]);

        $this->db()->table((new Village())->getTable())->insert([
            'village_code' => '2002',
            'village_name' => 'Desa Mojogedang',
            'district_code' => '15',
            'regency_code' => '13',
            'province_code' => '33',
            'zip_code' => '57752',
        ]);
    }
}
