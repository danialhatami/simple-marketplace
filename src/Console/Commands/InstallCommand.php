<?php

namespace Danial\SimpleMarketplace\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simple-marketplace:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Simple Marketplace package';

    public function handle(): void
    {
        if (!Schema::hasTable('users')) {
            $this->error('User table not found. Please run the Laravel default migrations first.');
            return;
        }

        Artisan::call('storage:link');
        $this->info('Storage link created');

        $timestamp = Carbon::now()->format('Y_m_d_His');
        $migrationsPath = database_path('migrations/');
        $stubPath = __DIR__ . '/../../database/migrations/';

        $files = File::files($stubPath);

        foreach ($files as $file) {
            $migrationName = $timestamp . '_' . $file->getBasename('.stub') . '.php';
            File::copy($file->getPathname(), $migrationsPath . $migrationName);
        }

        $this->info('Migrations Published');

        File::copy(__DIR__ . '/../../config/marketplace.php', config_path('marketplace.php'));

        $this->info('Config File Published');

        $this->info('Simple Marketplace package installed successfully');
    }
}
