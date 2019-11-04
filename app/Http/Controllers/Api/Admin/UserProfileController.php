<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\ReportUser;
use OneSignal;

class UserProfileController extends Controller
{
    public function index(Request $request)
    {
        $userProfiles = UserProfile::whereRaw("1=1");

        if ($request->name_like) {
            $userProfiles = $userProfiles->where('name', 'like', "%" . $request->name_like . "%");
        }

        return response()->json($userProfiles->orderBy('created_at', 'asc')->paginate(config('constants.paginate_per_page')));
    }

    public function show(UserProfile $profile)
    {
        return response()->json($profile);
    }

    public function update(UserProfile $profile, Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'gender' => ['required', Rule::in(config('constants.enums.gender'))],
            'notification_on_like' => ['required', 'boolean'],
            'notification_on_dislike' => ['required', 'boolean'],
            'notification_on_comment' => ['required', 'boolean'],
            'is_blocked' => ['required', 'boolean'],
            'image' => ['sometimes', 'image']
        ]);

        $profile->fill($request->all());
        $profile->save();

        if ($request->image) {
            $path = $request->file('image')->store('uploads');
            $profile->image = Storage::url($path);
        }

        return response()->json($profile);
    }

    public function destroy(UserProfile $userprofile)
    {
        $userprofile->delete();

        return response()->json([], 204);
    }

    public function sendPushNotification(UserProfile $userprofile, Request $request)
    {
        $request->validate([
            'message' => 'required|max:255'
        ]);

        $token = $userprofile->fcm_registration_id;

        OneSignal::sendNotificationToUser($request->message, $token);
        return response()->json([], 204);
    }

    public function sendPushNotificationToAll(Request $request)
    {
        $request->validate([
            'message' => 'required|max:255'
        ]);

        OneSignal::sendNotificationToAll($request->message);

        return response()->json([], 201);
    }

    public function reportedUsers(Request $request)
    {
        $reportedUsers = ReportUser::whereRaw("1=1");

        return response()->json($reportedUsers->orderBy('created_at', 'asc')->paginate(config('constants.paginate_per_page')));
    }

    public function block(UserProfile $profile)
    {
        $profile->is_blocked = true;
        $profile->save();

        return response()->json([], 200);
    }
}
