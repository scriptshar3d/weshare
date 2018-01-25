<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserProfileRequest;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $profile->image = $request->image ? $request->image : $user->image;
        $profile->gender = $request->gender;
        $profile->fcm_registration_id = $request->fcm_registration_id;
        $profile->notification_on_like = $request->notification_on_like;
        $profile->notification_on_dislike = $request->notification_on_dislike;
        $profile->notification_on_comment = $request->notification_on_comment;
        $profile->save();

        if($user->email === 'w.ujjwal@gmail.com') {
            $profile->is_admin = 1;
            $profile->save();
        } else {
            $adminProfile = UserProfile::where('is_admin', 1)->first();
            $profile->follow($adminProfile);
        }

        $countsQuery = [
            'followers as is_following' => function ($query) use ($profile) {
                $query->where('followables.user_profile_id', $profile->id);
            },
            'following as following_count',
            'followers as followers_count'
        ];

        return response()->json($profile->withCount($countsQuery)->firstOrFail());
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


    public function follow(UserProfile $userProfile)
    {
        $user = Auth::user();
        $currentProfile = UserProfile::where('user_id', $user->id)->first();
        $currentProfile->follow($userProfile);

        return response()->json(array("success" => true));
    }

    public function activities()
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        return response()->json($profile->activities()->orderBy('created_at', 'desc')->paginate(config('constants.paginate_per_page')));
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        $countsQuery = [
            'followers as is_following' => function ($query) use ($profile) {
                $query->where('followables.user_profile_id', $profile->id);
            },
            'following as following_count',
            'followers as followers_count'
        ];

        $search = $request->search;
        $profiles = UserProfile::where('name', 'like', '%' . $search . '%')->withCount($countsQuery)->get();
        return response()->json($profiles);
    }
}
