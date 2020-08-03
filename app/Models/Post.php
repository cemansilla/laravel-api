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
        return $this->hasMany('App\Models\Comment');
    }

    public function author(){
        return $this->belongsTo('App\User', 'author_id');
    }
}
