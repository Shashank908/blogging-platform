<?php

namespace App\Import;

use DB;
use Config;
use Exception;
use App\Models\Post;
use Elasticsearch\ClientBuilder;

class SyncDBWithES
{
    public function handle()
    {
        dump('Re-sync Started...........');
        
        DB::table('posts')
            ->join('users','users.id','=','posts.user_id')
            ->orderBy('posts.created_at', 'ASC')->chunk(100, function ($posts) {
            $client = ClientBuilder::create()
                        ->setHosts([Config::get('blog.elsatic_search.es_url')])
                        ->build();
            foreach ($posts as $post) {
                try {
                    $params = [
                        'index' => Config::get('blog.elsatic_search.default_index'),
                        'id'    => $post->id,
                        'body'  => [
                                    "id" => $post->id, 
                                    "title" => $post->title,
                                    "body" => $post->body,
                                    "user_id" => $post->id,
                                    "is_published" => $post->is_published,
                                    "user_name" => $post->name,
                                    "created_at" => $post->created_at,
                                    "updated_at" => $post->updated_at,
                                ]
                        ];
                    
                    $response = $client->index($params);
                    dump('Re-indexing done for post id:- '. $post->id);
                } catch (Exception $ex) {
                    dump($ex->getMessage());
                }
            }
        });
    }
}