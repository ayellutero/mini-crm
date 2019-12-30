<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minicrm:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up Mini-CRM project';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('WARNING: Make sure you have COMPOSER, ARTISAN, and NPM installed.');
        $this->info('WARNING: Make sure the DB_DATABASE, DB_USERNAME, DB_PASSWORD keys in your .env file are properly configured.');
        $this->info('WARNING: This command will generate a new application key for your project.');
        $this->info('WARNING: This command will drop your existing tables (if any) in the database.');
        
        // run composer install, php artisan key:generate, php artisan migrate, php artisan db:seed, npm install, npm run dev, storage:link
        if ($this->confirm('Do you wish to continue?')) {
            $commands = ['composer install', 'php artisan key:generate', 'php artisan migrate:fresh', 'php artisan db:seed', 'npm install', 'npm run dev', 'php artisan storage:link'];

            $bar = $this->output->createProgressBar(count($commands));

            $bar->start();

            foreach ($commands as $command) {
                $this->info(PHP_EOL . 'Running "' . $command . '"');
                exec($command);
                $this->info('Done.');
                $bar->advance();
            }

            $bar->finish();
            $this->info(PHP_EOL . 'Your project is now ready.');

        }
    }
}
