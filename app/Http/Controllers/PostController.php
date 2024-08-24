<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class PostController extends Controller
{
    public function comments(Request $request)
    {
        return Comment::where('post_id', $request->postId)->paginate($request->limit || 10);
    }
}
