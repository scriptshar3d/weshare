<?php

namespace App\Http\Controllers\Api;

use App\Models\PostActivity;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostActivityController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        $activities = PostActivity::has('post.user_id', $profile->id);
        return response()->json($activities);
    }
}
