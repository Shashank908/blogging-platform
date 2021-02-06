<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Config;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Elasticsearch\ClientBuilder;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::user()->id; 
        $es_data = $this->searchESdata($user_id);
        $posts = [];
        foreach ($es_data['hits'] as $key => $value) 
        {
            $posts[] = $value['_source'];
        }

        return view('admin.posts.index', compact('posts'));
    }

    public function searchESdata($user_id)
    {
//         $deleteParams = [
//             'index' => Config::get('blog.elsatic_search.default_index')
//         ];
//         $client = ClientBuilder::create()
//                                 ->setHosts([Config::get('blog.elsatic_search.es_url')])
//                                 ->build();
//         $response = $client->indices()->delete($deleteParams);
// dd($response);

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
        $client = ClientBuilder::create()
                                ->setHosts([Config::get('blog.elsatic_search.es_url')])
                                ->build();
        $response = $client->search($params);
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
        $client = ClientBuilder::create()
                                ->setHosts([Config::get('blog.elsatic_search.es_url')])
                                ->build();
        $response = $client->index($params);

        flash()->overlay('Post created successfully.');

        return redirect('/admin/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post = $post->load(['user']);

        return view('admin.posts.show', compact('post'));
    }

    public function publish(Post $post)
    {
        $post->is_published = ! $post->is_published;
        $post->save();
        flash()->overlay('Post changed successfully.');

        return redirect('/admin/posts');
    }
}
