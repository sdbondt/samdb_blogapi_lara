<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class PostController extends Controller
{
    public function index() {
        $posts = Post::latest()->filter(request(['search', 'category', 'author']))->paginate(10);
        return ['posts' => $posts];
    }

    public function show(Post $post) {
        return ['post' => $post];
    }

    public function store() {
        $attributes = request()->validate([
            'title' => 'required',
            'excerpt' => 'required',
            'body' => 'required',
            'slug' => ['required', Rule::unique('posts', 'slug')],
            'category_id' => ['required', Rule::exists('categories', 'id')]
        ]);

        $attributes['user_id'] = auth()->user()->id;
        $post = Post::create($attributes);
        return ['post' => $post];
    }

    public function update(Post $post) {
        $attributes = request()->validate([
            'title' => 'required',
            'excerpt' => 'required',
            'body' => 'required',
            'slug' => ['required', Rule::unique('posts', 'slug')->ignore($post->id)],
            'category_id' => ['required', Rule::exists('categories', 'id')]
        ]);

        $post->update($attributes);
        return ['post' => $post];
    }

    public function destroy(Post $post) {
        $post->delete();
    }
}
