<?php

namespace Vermaysha\Territory;

use Illuminate\Support\ServiceProvider;
use Vermaysha\Territory\Commands\InstallCommand;
use Vermaysha\Territory\Commands\SyncDBCommand;

class TerritoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('vermaysha.territory', TerritoryService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/territory_id.php' => config_path('territory_id.php'),
        ], 'territory-config');

        $this->mergeConfigFrom(__DIR__.'/../config/territory_id.php', 'territory_id');

        $this->publishesMigrations([
            __DIR__.'/../databases/migrations/create_territory_table.php' => database_path('migrations/'.date('Y_m_d_His').'_create_territory_table.php'),
        ], 'territory-migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                SyncDBCommand::class,
                InstallCommand::class,
            ]);
        }
    }
}
