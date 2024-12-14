<?php

namespace Vermaysha\Territory\Tests;

use Orchestra\Testbench\Concerns\WithWorkbench;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    protected function getPackageProviders($app)
    {
        return [
            // Daftarkan service provider package Anda
            \Vermaysha\Territory\TerritoryServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Territory' => \Vermaysha\Territory\Facade\Territory::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->setDatabase($app);
        $app['config']->set('cache.default', 'array');
    }

    protected function setDatabase($app)
    {
        $defaultDb = env('DB_CONNECTION', 'sqlite');

        $app['config']->set('database.default', $defaultDb);

        switch ($defaultDb) {
            case 'sqlite':
                $app['config']->set('database.connections.sqlite', [
                    'driver' => 'sqlite',
                    'database' => ':memory:',
                    'prefix' => '',
                ]);
                break;

            case 'mysql':
                $app['config']->set('database.connections.mysql', [
                    'driver' => 'mysql',
                    'host' => env('DB_HOST', '127.0.0.1'),
                    'port' => env('DB_PORT', '3306'),
                    'database' => env('DB_DATABASE', 'testbench'),
                    'username' => env('DB_USERNAME', 'root'),
                    'password' => env('DB_PASSWORD', ''),
                    'prefix' => '',
                ]);
                break;

            case 'pgsql':
                $app['config']->set('database.connections.pgsql', [
                    'driver' => 'pgsql',
                    'host' => env('DB_HOST', '127.0.0.1'),
                    'port' => env('DB_PORT', '5432'),
                    'database' => env('DB_DATABASE', 'testbench'),
                    'username' => env('DB_USERNAME', 'postgres'),
                    'password' => env('DB_PASSWORD', ''),
                    'prefix' => '',
                    'schema' => 'public',
                ]);
                break;
        }
    }
}
