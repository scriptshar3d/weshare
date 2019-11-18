<?php

namespace App\Http\Controllers\Api;

use App\Models\ReportUser;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Models\FollowRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PushNotificationHelper;
use App\Http\Requests\UserProfileRequest;

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
        if ($request->update == "1") {
            $profile->name = $request->name ? $request->name : $user->name;
            $profile->image = $request->image ? $request->image : $user->image;
            $profile->gender = $request->gender;
            $profile->fcm_registration_id = $request->fcm_registration_id;
            $profile->notification_on_like = $request->notification_on_like;
            $profile->notification_on_dislike = $request->notification_on_dislike;
            $profile->notification_on_comment = $request->notification_on_comment;
            $profile->is_private = $request->is_private;
        } else {
            $profile->name = $profile->name ? $profile->name : $user->name;
            $profile->image = $profile->image ? $profile->image : $user->image;
            $profile->gender = $profile->gender ? $profile->gender : $request->gender;
            $profile->fcm_registration_id = $request->fcm_registration_id;
            $profile->notification_on_like = $profile->notification_on_like ? $profile->notification_on_like : $request->notification_on_like;
            $profile->notification_on_dislike = $profile->notification_on_dislike ? $profile->notification_on_dislike : $request->notification_on_dislike;
            $profile->notification_on_comment = $profile->notification_on_comment ? $profile->notification_on_comment : $request->notification_on_comment;
            $profile->is_private = $profile->is_private ? $profile->is_private : $request->is_private;
        }
        $profile->save();
        /*if ($user->email === 'owhloapp@gmail.com') {
            $profile->is_admin = 1;
            $profile->save();
        } else {
            $adminProfile = UserProfile::where('is_admin', 1)->first();
            $profile->follow($adminProfile);
        }*/

        $countsQuery = [
            'followers as is_following' => function ($query) use ($profile) {
                $query->where('followables.user_profile_id', $profile->id);
            },
            'following as following_count',
            'followers as followers_count'
        ];
        return response()->json(UserProfile::where('id', $profile->id)->withCount($countsQuery)->firstOrFail());
    }


    public function show(UserProfile $userProfile)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

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
            },
            'followers as is_following' => function ($query) use ($profile) {
                $query->where('followables.user_profile_id', $profile->id);
            },
            'following as following_count',
            'followers as followers_count'
        ];
        return response()->json(UserProfile::where('id', $userProfile->id)->withCount($countsQuery)->firstOrFail());
    }


    public function follow(UserProfile $userProfile)
    {
        $success = 0; // no action
        $user = Auth::user();
        $currentProfile = UserProfile::where('user_id', $user->id)->first();

        if (!$userProfile->is_private) {
            if ($currentProfile->isFollowing($userProfile)) {
                $currentProfile->unfollow($userProfile);
                $success = 1; // unfollow
            } else {
                $currentProfile->follow($userProfile);
                $success = 2; // follow
            }
        }
        return response()->json(array("success" => $success));
    }

    public function followers(UserProfile $userProfile)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        $ids = $userProfile->followers()->pluck('user_profile_id')->all();

        $profiles = UserProfile::whereIn('id', $ids);

        $countsQuery = [
            'followers as is_following' => function ($query) use ($profile) {
                $query->where('followables.user_profile_id', $profile->id);
            },
            'following as following_count',
            'followers as followers_count'
        ];


        return response()->json($profiles->withCount($countsQuery)->paginate(config('constants.paginate_per_page')));
        //return response()->json($userProfile->followers()->withCount($countsQuery)->get());
        //return response()->json($userProfile->followers()->get());

    }

    public function following(UserProfile $userProfile)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        $ids = $userProfile->followings()->pluck('id')->all();

        $profiles = UserProfile::whereIn('id', $ids);

        $countsQuery = [
            'followers as is_following' => function ($query) use ($profile) {
                $query->where('followables.user_profile_id', $profile->id);
            },
            'following as following_count',
            'followers as followers_count'
        ];


        return response()->json($profiles->withCount($countsQuery)->paginate(config('constants.paginate_per_page')));

        //return response()->json($userProfile->followings()->get());
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
        $profiles = UserProfile::where('name', 'like', '%' . $search . '%')->withCount($countsQuery)->paginate(config('constants.paginate_per_page'));
        return response()->json($profiles);
    }

    public function report(UserProfile $reportUser, Request $request)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'message' => 'required|string'
        ]);

        $report = ReportUser::create([
            'message' => $request->message,
            'user_profile_id' => $reportUser->id,
            'reported_by' => $profile->id
        ]);

        return response()->json($report->refresh());
    }

    public function followRequest(UserProfile $userprofile, Request $request)
    {
        $user = Auth::user();
        $requestedByProfile = UserProfile::where('user_id', $user->id)->firstOrFail();
        $follow = false;

        $existingRequest = FollowRequest::where('user_profile_id', $userprofile->id)
            ->where('requested_by_profile_id', $requestedByProfile->id)->first();

        // toggle between follow request, if request is already there delete it,
        // if request does not exist then create a request
        if ($existingRequest) {
            $existingRequest->delete();
            $follow = false;
        } else {
            FollowRequest::create([
                'user_profile_id' => $userprofile->id,
                'requested_by_profile_id' => $requestedByProfile->id
            ]);
            $follow = true;

            // send notification to user
            $title = "New request to follow you";
            $body = $requestedByProfile->name . " requested to follow you";
            $data = ["profile_id" => $requestedByProfile->id];
            PushNotificationHelper::send($userprofile->fcm_registration_id, $title, $body, $data);
        }

        return response()->json(["follow_request" => $follow]);
    }

    public function followRequests()
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        return response()->json(FollowRequest::where('user_profile_id', $profile->id)->get());
    }

    public function reviewFollowRequest(FollowRequest $followrequest, Request $request)
    {
        $request->validate(
            [
                'accept' => 'required|boolean'
            ]
        );
        $follow = 0;

        $requestedBy = $followrequest->requested_by->id;
        $profileToFollow = $followrequest->profile->id;

        if ($request->accept) {
            $requestedBy->follow($profileToFollow);
            $follow = 1;

            // send notification to user
            $title = "Follow request accepted";
            $body = $profileToFollow->name . " accepted your follow request";
            $data = ["profile_id" => $profileToFollow->id];
            PushNotificationHelper::send($requestedBy->fcm_registration_id, $title, $body, $data);
        }

        // delete follow request eventually
        $followrequest->delete();

        return response()->json(["follow" => $follow]);
    }
}
