<?php

namespace Vermaysha\Territory\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'territory:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install package';

    public function handle()
    {
        $publishConfig = strtolower($this->ask('Are you want to publish configuration file? (y/n)', 'y'));

        if ($publishConfig === 'y') {
            $this->call('vendor:publish', [
                '--tag' => 'territory-config',
            ]);
        }

        $publishMigration = strtolower($this->ask('Are you want to publish migration file? (y/n)', 'y'));

        if ($publishMigration === 'y') {
            $this->call('vendor:publish', [
                '--tag' => 'territory-migrations',
            ]);
        }

        $syncNow = strtolower($this->ask('Are you want to sync database now? (y/n)', 'y'));

        if ($syncNow === 'y') {
            $this->call('migrate');
            $this->call('territory:sync');
        }

        $this->info('Done!');
    }
}
