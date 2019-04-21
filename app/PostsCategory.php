<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostsCategory extends Model
{
    public $table = 'category_post';
    public $fillable = [
        'post_id', 'category_id',
    ];
    public $timestamps = false;
}
