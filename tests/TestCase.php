<?php

namespace Vermaysha\Wilayah\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Vermaysha\Wilayah\ServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migrationsFiles = [
            'create_provinces_table.php.stub',
            'create_cities_table.php.stub',
            'create_districts_table.php.stub',
            'create_village_table.php.stub',
        ];

        foreach ($migrationsFiles as $file) {
            $migration = include __DIR__.'/../database/migrations/'.$file;
            $migration->up();
        }
    }
}
