<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function storeComment(Post $post) {

        $comment = new Comment([
            'post_id' => $post->id,
            'comment' => request('comment')
        ]);

        $post->comments()->save($comment);

        return response()->json($comment, 201);

    }
}
