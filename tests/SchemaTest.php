<?php

namespace Vermaysha\Territory\Tests;

use Illuminate\Support\Facades\Schema;
use Vermaysha\Territory\Models\District;
use Vermaysha\Territory\Models\Province;
use Vermaysha\Territory\Models\Regency;
use Vermaysha\Territory\Models\Village;

class SchemaTest extends TestCase
{
    /**
     * Setup the test environment.
     *
     * This method is called before each test is executed.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/../databases/migrations');
    }

    /**
     * Test if the database can be migrated freshly without errors.
     *
     * This test runs the 'migrate:fresh' Artisan command with the '--force' option
     * and asserts that it exits with code 0, indicating success.
     *
     * @return void
     */
    public function test_can_migrate()
    {
        $this->artisan('migrate:fresh', ['--force' => true])->assertExitCode(0);
    }

    /**
     * Test if the provinces table exists in the database.
     *
     * This test creates a fresh migration of the database and asserts that the
     * provinces table exists in the database.
     *
     * @return void
     */
    public function test_has_provinces_table()
    {
        $this->assertTrue(Schema::connection(config('territory_id.connection'))->hasTable((new Province())->getTable()));
    }

    /**
     * Test if the regencies table exists in the database.
     *
     * This test creates a fresh migration of the database and asserts that the
     * regencies table exists in the database.
     *
     * @return void
     */
    public function test_has_regencies_table()
    {
        $this->assertTrue(Schema::connection(config('territory_id.connection'))->hasTable((new Regency())->getTable()));
    }

    /**
     * Test if the districts table exists in the database.
     *
     * This test creates a fresh migration of the database and asserts that the
     * districts table exists in the database.
     *
     * @return void
     */
    public function test_has_districts_table()
    {
        $this->assertTrue(Schema::connection(config('territory_id.connection'))->hasTable((new District())->getTable()));
    }

    /**
     * Test if the villages table exists in the database.
     *
     * This test creates a fresh migration of the database and asserts that the
     * villages table exists in the database.
     *
     * @return void
     */
    public function test_has_villages_table()
    {
        $this->assertTrue(Schema::connection(config('territory_id.connection'))->hasTable((new Village())->getTable()));
    }

    /**
     * Test if the provinces table has the expected columns.
     *
     * This test retrieves the columns of the provinces table using the
     * 'getColumnListing' method of the Schema facade and compares them to the
     * configured columns names in the 'territory_id.column_names.provinces' config
     * key. It asserts that the columns match the configured column names.
     *
     * @return void
     */
    public function test_provinces_has_expected_columns()
    {
        $columns = Schema::connection(config('territory_id.connection'))->getColumnListing((new Province())->getTable());
        $configuredColumns = [
            'province_code',
            'province_name'
        ];

        sort($configuredColumns);
        sort($columns);

        $this->assertEquals($configuredColumns, $columns);
    }

    /**
     * Test if the regencies table has the expected columns.
     *
     * This test retrieves the columns of the regencies table using the
     * 'getColumnListing' method of the Schema facade and compares them to the
     * configured columns names in the 'territory_id.column_names.regencies' config
     * key. It asserts that the columns match the configured column names.
     *
     * @return void
     */
    public function test_regencies_has_expected_columns()
    {
        $columns = Schema::connection(config('territory_id.connection'))->getColumnListing((new Regency())->getTable());
        $configuredColumns = [
            'province_code',
            'regency_code',
            'regency_name',
        ];

        sort($configuredColumns);
        sort($columns);

        $this->assertEquals($configuredColumns, $columns);
    }

    /**
     * Test if the districts table has the expected columns.
     *
     * This test retrieves the columns of the districts table using the
     * 'getColumnListing' method of the Schema facade and compares them to the
     * configured columns names in the 'territory_id.column_names.districts' config
     * key. It asserts that the columns match the configured column names.
     *
     * @return void
     */
    public function test_districts_has_expected_columns()
    {
        $columns = Schema::connection(config('territory_id.connection'))->getColumnListing((new District())->getTable());
        $configuredColumns = [
            'province_code',
            'regency_code',
            'district_code',
            'district_name',
        ];

        sort($configuredColumns);
        sort($columns);

        $this->assertEquals($configuredColumns, $columns);
    }

    /**
     * Test if the villages table has the expected columns.
     *
     * This test retrieves the columns of the villages table using the
     * 'getColumnListing' method of the Schema facade and compares them to the
     * configured columns names in the 'territory_id.column_names.villages' config
     * key. It asserts that the columns match the configured column names.
     *
     * @return void
     */
    public function test_villages_has_expected_columns()
    {
        $columns = Schema::connection(config('territory_id.connection'))->getColumnListing((new Village())->getTable());
        $configuredColumns = [
            'province_code',
            'regency_code',
            'district_code',
            'village_code',
            'village_name',
            'zip_code',
        ];

        sort($configuredColumns);
        sort($columns);

        $this->assertEquals($configuredColumns, $columns);
    }
}
