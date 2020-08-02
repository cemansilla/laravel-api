<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'author_id'
    ];

    public function comments(){
        $this->hasMany('App\Models\Comment');
    }

    public function author(){
        $this->belongTo('App\User', 'author_id');
    }
}
