<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserProfileRequest;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\OAuth1\Client\Server\User;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
    public function store(UserProfileRequest $request)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->first();
        if (!$profile) {
            $profile = new UserProfile();
        }

        $profile->user_id = $user->id;
        $profile->name = $request->name ? $request->name : $user->name;
        $profile->gender = $request->gender;
        $profile->fcm_registration_id = $request->fcm_registration_id;
        $profile->notification_on_like = $request->notification_on_like;
        $profile->notification_on_dislike = $request->notification_on_dislike;
        $profile->notification_on_comment = $request->notification_on_comment;
        $profile->save();

        return response()->json($profile);
    }

    public function show()
    {
        $user = Auth::user();

        $countsQuery = [
            'posts as posts_count',
            'activities as like_count' => function ($query) {
                $query->where('post_activities.type', config('constants.POST_ACTIVITY_LIKE'));
            },
            'activities as dislike_count' => function ($query) {
                $query->where('post_activities.type', config('constants.POST_ACTIVITY_DISLIKE'));
            },
            'activities as comment_count' => function ($query) {
                $query->where('post_activities.type', config('constants.POST_ACTIVITY_COMMENT'));
            }
        ];
        return response()->json(UserProfile::where('user_id', $user->id)->withCount($countsQuery)->firstOrFail());
    }

    public function activities()
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        return response()->json($profile->activities()->orderBy('created_at', 'desc')->paginate(config('constants.paginate_per_page')));
    }
}
