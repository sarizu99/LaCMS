<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $fillable = [
        'slug',
        'title', 
        'author_id', 
        'content', 
        'published', 
        'views', 
        'thumbnail',
        'comments_enabled'
    ];

    public function categories()
    {
        return $this->belongsToMany('\App\Category');
    }

    public function author()
    {
        return $this->belongsTo('\App\User');
    }
}