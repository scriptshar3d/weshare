<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PostHelper;
use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use App\Models\PostActivity;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        $countsQuery = [
            'post_activities as like_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_LIKE'));
            },
            'post_activities as dislike_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_DISLIKE'));
            },
            'post_activities as comment_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_COMMENT'));
            },
            'post_activities as liked' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_LIKE'));
            },
            'post_activities as disliked' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_DISLIKE'));
            },
            'post_activities as commented' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_COMMENT'));
            }
        ];
        $following = array_merge($profile->followings()->pluck('id')->all(), [$profile->id]);
        $posts = Post::whereIn('user_profile_id', $following);
	if($request->type) {
		$posts = $posts->where('type', $request->type);
	}
	if($request->user_profile_id) {
		$posts = $posts->where('user_profile_id', $request->user_profile_id);
	}
	$posts = $posts->orderBy('created_at', 'desc')->withCount($countsQuery)->paginate(config('constants.paginate_per_page'));
        return response()->json($posts);
    }

    public function show(Post $post)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        $countsQuery = [
            'post_activities as like_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_LIKE'));
            },
            'post_activities as dislike_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_DISLIKE'));
            },
            'post_activities as comment_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_COMMENT'));
            },
            'post_activities as liked' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_LIKE'));
            },
            'post_activities as disliked' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_DISLIKE'));
            },
            'post_activities as commented' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_COMMENT'));
            }
        ];
        return response()->json(Post::where('id', $post->id)->withCount($countsQuery)->first());
    }

    public function myposts(Request $request)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        $countsQuery = [
            'post_activities as like_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_LIKE'));
            },
            'post_activities as dislike_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_DISLIKE'));
            },
            'post_activities as comment_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_COMMENT'));
            },
            'post_activities as liked' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_LIKE'));
            },
            'post_activities as disliked' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_DISLIKE'));
            },
            'post_activities as commented' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_COMMENT'));
            }
        ];

	$posts = Post::where('user_profile_id', $profile->id);

	if($request->type) {
                $posts = $posts->where('type', $request->type);
        }

        $posts = $posts->orderBy('created_at', 'desc')->withCount($countsQuery)->paginate(config('constants.paginate_per_page'));
        return response()->json($posts);
    }

    public function like(Post $post)
    {
        $status = $this->likeDislikePost($post, config('constants.POST_ACTIVITY_LIKE'));
        return response()->json(array("id" => $post->id, "status" => $status), 200);
    }

    public function dislike(Post $post)
    {
        $status = $this->likeDislikePost($post, config('constants.POST_ACTIVITY_DISLIKE'));

        return response()->json(array("id" => $post->id, "status" => $status), 200);
    }

    public function share(Post $post)
    {
        $post->share_count = $post->share_count + 1;
        $post->save();
        return response()->json(null, 200);
    }

    public function store(CreatePostRequest $request)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->first();
        $post = new Post();
	$post->title = $request->title;
        $post->text = $request->text;
        $post->media_url = $request->media_url;
        $post->type = $request->type;
        $post->user_profile_id = $profile->id;
        $post->video_thumbnail_url = $request->video_thumbnail_url;
	$post->category_id = $request->category_id;
        $post->save();

        return response()->json(Post::find($post->id));
    }

    public function destroy(Post $post)
    {
        $deleted = $post->delete();
        $status = $deleted ? 200 : 400;
        return response()->json(null, $status);
    }

    private function likeDislikePost($post, $type)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        $previousActivity = PostActivity::where('user_profile_id', $profile->id)
            ->where('post_id', $post->id)
            ->whereIn('type', array(config('constants.POST_ACTIVITY_LIKE'), config('constants.POST_ACTIVITY_DISLIKE')))
            ->first();

        if ($previousActivity) {
            $previousActivity->delete();

            if ($previousActivity->type == $type) {
                return -1; // unlike or undislike
            }
        }

	if($post->user_profile_id == $profile->id) { return 1; }

        PostHelper::createPostActivity($profile, $post->id, $type);
        return 1; // like or dislike
    }
}
