<?php

namespace App\Console\Commands;

use App\Import\EsMapping;
use Illuminate\Console\Command;

class CreateESMapping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:mapping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command is used to create mapping for Elastic search index';

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
        $mapping = new EsMapping;
        $mapping->handle();
    }
}