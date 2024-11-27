<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index() {

        $posts = Post::all();

        return $posts;

    }
    public function create(Request $request) {
        $request->validate([
            'post_name' => 'required|string|max:50',
            'post_desc' => 'required|string|max:255'
        ]);

        Post::create($request->all());

        return response()->json(['success' => 'Creado Ok!'], 201);
    }

    public function show(Post $post) {
        return $post->load('comments');
    }

    public function update(Post $post) {

        $post->update(request()->all());

        return response()->json($post, 200);
    }

    public function destroy(Post $post)
{
    $post->delete();

    return response()->json('deleted', 204);
}


}
