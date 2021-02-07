<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Models\Post;
use Session;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_home_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_home_page_ajax()
    {
        $response = $this->get('/', array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $response->assertStatus(200);
    }

    public function test_homepage()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/home');

        $response->assertStatus(200);
    }

    public function test_create_post()
    {
        Session::start();
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->call('POST', '/admin/posts', array(
            '_token' => csrf_token(),
            'title' => 'title',
            'body' => 'ff'
        ));
        
        $response->assertStatus(302);
    }

    public function test_show_post()
    {
        $post = Post::first();
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/posts/'.$post->id);
        
        $response->assertStatus(200);
        
    }
}
