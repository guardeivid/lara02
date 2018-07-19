<?php

namespace App\Webartis;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //protected $table = 'posts';
    protected $table = 'otro.posts';

    protected $guarded = ['id'];
}
