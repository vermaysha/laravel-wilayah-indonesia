<?php

namespace Vermaysha\LaravelWilayahIndonesia\Commands;

use Illuminate\Console\Command;

class LaravelWilayahIndonesiaCommand extends Command
{
    public $signature = 'laravel-wilayah-indonesia';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
