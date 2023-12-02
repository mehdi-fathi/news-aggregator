<?php

namespace App\Console\Commands;

use App\Jobs\GuardianNewsAPICollectorJob;
use App\Jobs\NewsAPICollectorJob;
use Illuminate\Console\Command;

class newsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:news-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        NewsAPICollectorJob::dispatch();
        GuardianNewsAPICollectorJob::dispatch();
    }
}
