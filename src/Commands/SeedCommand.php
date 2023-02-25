<?php

namespace Vermaysha\LaravelWilayahID\Commands;

use Illuminate\Console\Command;

class SeedCommand extends Command
{
    public $signature = 'wilayah-id:seed';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
