<?php

namespace App\Console\Commands;

use App\Import\ImportPosts;
use Illuminate\Console\Command;

class ImportBlogPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:blog-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto import the posts from another blogging platform';

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
        \Log::info("Cron is working fine!");
        $import = new ImportPosts;
        $import->handle();
    }
}
