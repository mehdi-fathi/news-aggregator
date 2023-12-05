<?php

namespace App\Console\Commands;

use App\Jobs\GuardianNewsAPICollectorJob;
use App\Jobs\NewsAPICollectorJob;
use App\Logic\Service\NewsService;
use Illuminate\Console\Command;

/**
 *
 */
class NewsCommand extends Command
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
    protected $description = 'This command is able to fetch all news and save them in database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        NewsAPICollectorJob::dispatch();

        GuardianNewsAPICollectorJob::dispatch();
    }
}
