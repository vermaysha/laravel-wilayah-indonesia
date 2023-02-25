<?php

namespace Vermaysha\Wilayah;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Vermaysha\Wilayah\Commands\SeedCommand;

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
            ->name('wilayah')
            ->hasConfigFile('wilayah')
            ->hasMigrations([
                'create_provinces_table',
                'create_cities_table',
                'create_districts_table',
                'create_village_table',
            ])
            ->hasCommand(SeedCommand::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->setDescription('Install vermaysha/laravel-wilayah-indonesia package')
                    ->setHidden(false)
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToStarRepoOnGitHub('vermaysha/laravel-wilayah-indonesia')
                    ->endWith(function (InstallCommand $command) {
                        $command->line('');
                        $command->info('Please run `php artisan migrate`');
                        $command->info('Please run `php artisan wilayah:seed` to produce data');
                    });
            });
    }
}
