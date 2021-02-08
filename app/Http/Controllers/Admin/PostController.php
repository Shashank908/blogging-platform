<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Config;
use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Elasticsearch\ClientBuilder;

class PostController extends Controller
{

    public function __construct()
    {
        $this->flag = true;
        try {
            $this->client = ClientBuilder::create()
                                ->setHosts([Config::get('blog.elsatic_search.es_url')])
                                ->build();
        } catch (Exception $th) {
            $this->flag = true;
            dump('Please Check elastic search connectivity.');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->flag) 
        {
            try {
                $user_id = Auth::user()->id;  
                $posts = $this->getPosts($user_id);
                return view('admin.posts.index', compact('posts'));
            } catch (Exception $th) {
                dump($th->getMessage());
            }
        }
    }

    public function getPosts($user_id)
    {
        $es_data = $this->searchESdata($user_id);
        $posts = [];
        foreach ($es_data['hits'] as $key => $value) 
        {
            $posts[] = $value['_source'];
        }
        return $posts;
    }

    public function searchESdata($user_id)
    {
        $params = [
            'index' => Config::get('blog.elsatic_search.default_index'),
            'body'  => [
                'query' => [
                    'match' => [
                        'user_id' => $user_id
                    ]
                ]
            ]
        ];
        
        $response = $this->client->search($params);
        return $response['hits'];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        try {
            $id = (string) Str::uuid();
            $user = Auth::user();
            $post = Post::create([
                'id'          => $id,
                'title'       => $request->title,
                'body'        => $request->body
            ]);
            $params = [
                'index' => Config::get('blog.elsatic_search.default_index'),
                'id'    => $id,
                'body'  => [
                            "id" => $id, 
                            "title" => $request->title,
                            "body" => $request->body,
                            "user_id" => $user->id,
                            "is_published" => 1,
                            "user_name" => $user->name,
                            "created_at" => gmdate('Y-m-d h:i:s'),
                            "updated_at" => gmdate('Y-m-d h:i:s')
                        ]
            ];
            
            $response = $this->client->index($params);
            flash()->overlay('Post created successfully.');
            return redirect('/admin/posts');
        } catch (Exception $ex) {
            flash()->overlay('Failed to create Post. Reason:- '.$ex->getMessage());
            return redirect('/admin/posts');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($post_id)
    {
        if ($this->flag) 
        {
            try {
                $params = [
                    'index' => Config::get('blog.elsatic_search.default_index'),
                    'id'    => $post_id
                ];
        
                $post = ($this->client->get($params))['_source'];
                return view('admin.posts.show', compact('post'));
            } catch (Exception $th) {
                dump($th->getMessage());
            }
        }
    }

    public function publish(Post $post)
    {
        $post->is_published = ! $post->is_published;
        $post->save();
        flash()->overlay('Post changed successfully.');

        return redirect('/admin/posts');
    }
}
