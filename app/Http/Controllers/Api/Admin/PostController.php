<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\ReportPost;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::whereRaw("1=1");

        return response()->json($posts->orderBy('created_at', 'desc')->paginate(config('constants.paginate_per_page')));
    }

    public function show(Post $post)
    {
        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        $post->forceDelete();

        return response()->json([], 204);
    }

    public function reportedPosts(Request $request)
    {
        $reportedPosts = ReportPost::whereRaw("1=1");

        return response()->json($reportedPosts->orderBy('created_at', 'desc')->paginate(config('constants.paginate_per_page')));
    }
}
