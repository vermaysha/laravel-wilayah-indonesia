<?php

namespace Vermaysha\LaravelWilayahIndonesia;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Vermaysha\LaravelWilayahIndonesia\Commands\LaravelWilayahIndonesiaCommand;

class LaravelWilayahIndonesiaServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-wilayah-indonesia')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-wilayah-indonesia_table')
            ->hasCommand(LaravelWilayahIndonesiaCommand::class);
    }
}
