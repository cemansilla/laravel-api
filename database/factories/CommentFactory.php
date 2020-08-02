<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use App\User;
use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'content' => $faker->text(200),
        'user_id' => User::all()->random(),
        'post_id' => Post::all()->random()
    ];
});
