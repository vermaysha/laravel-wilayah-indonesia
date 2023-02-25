<?php

namespace Vermaysha\Wilayah\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $signature = 'wilayah:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    public $description = 'Seed database wilayah';

    /**
     * The console command description.
     */
    public function handle(): int
    {
        Artisan::call('db:seed', ['--class' => '\Vermaysha\Wilayah\Seeds\DatabaseSeeder', '--force' => true]);
        $this->info('Seeded: \Vermaysha\Wilayah\Seeds\IndonesiaSeeder');

        return self::SUCCESS;
    }
}
