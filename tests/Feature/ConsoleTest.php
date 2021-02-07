<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConsoleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_reindex()
    {
        $this->artisan('es:reindexing')
            ->assertExitCode(0);
    }

    public function test_import_blog_post()
    {
        $this->artisan('import:blog-posts')
            ->assertExitCode(0);
    }

    public function test_es_mapping()
    {
        $this->artisan('es:mapping')
            ->assertExitCode(0);
    }
}
