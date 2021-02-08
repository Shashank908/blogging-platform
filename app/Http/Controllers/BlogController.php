<?php

namespace App\Http\Controllers;

use Config;
use Exception;
use App\Models\Post;
use Illuminate\Http\Request;
use Elasticsearch\ClientBuilder;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->flag = true;
        try {
            $this->client = ClientBuilder::create()
                    ->setHosts([Config::get('blog.elsatic_search.es_url')])
                    ->build();
        } catch (Exception $th) {
            dump('Please Check elastic search connectivity.');
            $this->flag = false;
        }
    }

    public function index(Request $request)
    {
        if ($this->flag) 
        {
            if ($request->ajax()) 
            {
                try {
                    $params = [
                        'index' => Config::get('blog.elsatic_search.default_index'),
                        "body" => ["sort" => [
                            ['created_at' => ['order' => 'desc']],
                        ]]
                    ];
                    $posts = $this->prepareData($this->client->search($params));
                    return view('frontend.data', compact('posts'));
                } catch (Exception $th) {
                    dump($th->getMessage());
                }
            }
            try {
                $params = [
                    'index' => Config::get('blog.elsatic_search.default_index'),
                    '_source' => '*'
                ];
                
                $posts = $this->prepareData($this->client->search($params));
                return view('frontend.index', compact('posts'));
            } catch (Exception $th) {
                dump($th->getMessage());
            }
        }
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
