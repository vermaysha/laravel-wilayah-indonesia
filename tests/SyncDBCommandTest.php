<?php

namespace Vermaysha\Territory\Tests;

use Illuminate\Support\Facades\DB;
use Vermaysha\Territory\Models\District;
use Vermaysha\Territory\Models\Province;
use Vermaysha\Territory\Models\Regency;

class SyncDBCommandTest extends TestCase
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
     * Test the sync database command.
     *
     * @return void
     */
    public function test_sync_is_working()
    {
        $this->artisan('territory:sync')->assertExitCode(0);
        $db = DB::connection(config('territory_id.connection', config('database.default')));

        $this->assertNotEmpty($db->table((new Province())->getTable())->count());
        $this->assertNotEmpty($db->table((new Regency())->getTable())->count());
        $this->assertNotEmpty($db->table((new District())->getTable())->count());
        $this->assertNotEmpty($db->table((new District())->getTable())->count());
    }
}
