<?php

namespace Vermaysha\LaravelWilayahIndonesia\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Vermaysha\LaravelWilayahIndonesia\LaravelWilayahIndonesia
 */
class LaravelWilayahIndonesia extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Vermaysha\LaravelWilayahIndonesia\LaravelWilayahIndonesia::class;
    }
}
