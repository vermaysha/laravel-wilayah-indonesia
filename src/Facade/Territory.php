<?php

namespace Vermaysha\Territory\Facade;

use Illuminate\Support\Facades\Facade;

class Territory extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'vermaysha.territory';
    }
}
