<?php

namespace App\Console\Commands;

use App\Import\SyncDBWithES;
use Illuminate\Console\Command;

class ReIndexESData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:reindexing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command is used to update the Database posts into elastic-search';

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
        $es_sync = new SyncDBWithES;
        $es_sync->handle();
    }
}
