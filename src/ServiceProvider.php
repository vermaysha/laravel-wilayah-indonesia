<?php

namespace Vermaysha\LaravelWilayahID;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Vermaysha\LaravelWilayahID\Commands\SeedCommand;

class ServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-wilayah-id')
            ->hasConfigFile('wilayah-id')
            ->hasMigrations([
                'create_provinces_table',
                'create_cities_table',
                'create_districts_table',
                'create_village_table',
            ])
            ->hasCommand(SeedCommand::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('vermaysha/laravel-wilayah-indonesia')
                    ->endWith(function (InstallCommand $command) {
                        $command->info('Please run `php artisan wilayah-id:seed` to produce data');
                    });
            });
    }
}
