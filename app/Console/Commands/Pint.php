<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Pint extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Wrapper for Laravel Pint\'s default command';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pint';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        passthru('./vendor/bin/pint');
    }
}
