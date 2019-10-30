<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $comments = Comment::whereRaw("1=1");

        return response()->json($comments->orderBy('created_at', 'desc')->paginate(config('constants.paginate_per_page')));
    }

    public function show(Comment $comment)
    {
        return response()->json($comment);
    }

    public function destroy(Comment $comment)
    {
        $comment->forceDelete();

        return response()->json([], 204);
    }
}
