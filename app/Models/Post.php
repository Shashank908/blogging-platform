<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $incrementing = false;
    protected $casts = ['id' => 'string'];

    protected $fillable = [
        'id',
        'title',
        'body',
        'user_id',
        'category_id',
        'is_published',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (is_null($post->user_id)) {
                $post->user_id = auth()->user()->id;
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
