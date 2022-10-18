<?php

namespace LaravelGreatApi\Access\Console\Commands;

use Illuminate\Console\Command;
use LaravelGreatApi\Access\Access;

class RefreshAccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'access:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Access::refresh();

        return $this->components->info('Access success refreshed!');
    }
}
