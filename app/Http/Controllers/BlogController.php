<?php

namespace App\Http\Controllers;

use Config;
use App\Models\Post;
use Illuminate\Http\Request;
use Elasticsearch\ClientBuilder;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $client = ClientBuilder::create()
                                ->setHosts([Config::get('blog.elsatic_search.es_url')])
                                ->build();
        if ($request->ajax()) 
        {
            $params = [
                'index' => Config::get('blog.elsatic_search.default_index'),
                "body" => ["sort" => [
                    ['created_at' => ['order' => 'desc']],
                ]]
            ];
            $posts = $this->prepareData($client->search($params));

            return view('frontend.data', compact('posts'));
        } else {
            $params = [
                'index' => Config::get('blog.elsatic_search.default_index'),
                '_source' => '*'
            ];
            
            $posts = $this->prepareData($client->search($params));
            
        }
        return view('frontend.index', compact('posts'));
    }

    public function prepareData($response)
    {
        $data = [];
        $raw_data = $response['hits']['hits'];
        foreach ($raw_data as $value) 
        {
            $data[] = $value['_source'];
        }
        return $data;
    }
}
