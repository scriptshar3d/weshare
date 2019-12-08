<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PostHelper;
use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use App\Models\PostActivity;
use App\Models\ReportPost;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * @group Post
 * @authenticated
 */
class PostController extends Controller
{
    /**
     * List of posts
     * @authenticated
     * @queryParam treding optional Show trending posts. Example: 0
     * @queryParam user_profile_id string Show posts of a users. Example: -1
     * @queryParam type string Filter posts on the basis of type. Example: text
     */
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
        if ($request->treding === "1") {
            $posts = Post::whereHas('user', function($query) {
                $query->where('is_private', false);
            });
        } else if ($request->user_profile_id && $request->user_profile_id != -1) {
            $posts = Post::where('user_profile_id', $request->user_profile_id);
        } else {
            $following = $profile->followings()->pluck('id')->all();
            $posts = Post::whereIn('user_profile_id', $following);            
        }
        
        if ($request->type) {
            $posts = $posts->where('type', $request->type);
        }        

        $posts = $posts->where('is_story', false);

        $posts = $posts->orderBy('created_at', 'desc')->withCount($countsQuery)->paginate(config('constants.paginate_per_page'));
        return response()->json($posts);
    }

    /**
     * Get a post by id
     * @authenticated
     */
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

    /**
     * List of posts posted by current user
     * @authenticated
     */
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

        if ($request->type) {
            $posts = $posts->where('type', $request->type);
        }

        $posts = $posts->orderBy('created_at', 'desc')->withCount($countsQuery)->paginate(config('constants.paginate_per_page'));
        return response()->json($posts);
    }


    /**
     * List of users who have posted stories
     * @authenticated
     */
    public function storyUsers()
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();
        $following = array_merge($profile->followings()->pluck('id')->all(), [$profile->id]);
        $users = Post::whereIn('user_profile_id', $following)->where('is_story', true)->get()->pluck('user_profile_id')->all();
        $userIds = [];
        foreach ($users as $user) {
            $userIds[] = $user->id;
        }
        return response()->json(UserProfile::whereIn('id', $userIds)->get());
    }

    /**
     * List of stories by a user
     * @authenticated
     */
    public function stories(UserProfile $userProfile)
    {
        $posts = Post::where('user_profile_id', $userProfile->id)->where('is_story', true)
            ->where('created_at', '>', Carbon::now()->subHours(24))
            ->orderBy('created_at', 'desc')->get();
        return response()->json($posts);
    }

    /**
     * Like a post
     * @authenticated
     */
    public function like(Post $post)
    {
        $status = $this->likeDislikePost($post, config('constants.POST_ACTIVITY_LIKE'));
        return response()->json(array("id" => $post->id, "status" => $status), 200);
    }

    /**
     * Dislike a post
     * @authenticated
     */
    public function dislike(Post $post)
    {
        $status = $this->likeDislikePost($post, config('constants.POST_ACTIVITY_DISLIKE'));

        return response()->json(array("id" => $post->id, "status" => $status), 200);
    }

    /**
     * Share a post
     * Share a post, this will increase share count, actually sharing is being handled at client side
     * @authenticated
     */
    public function share(Post $post)
    {
        $post->share_count = $post->share_count + 1;
        $post->save();
        return response()->json(null, 200);
    }

    /**
     * Create a new post
     * @authenticated
     * @bodyParam title string optional Title of the post
     * @bodyParam text string optional Text(body) of the post, required if parameter media_url is not set
     * @bodyParam media_url string optional  Media for the post, required if parameter text is not set
     * @bodyParam type string required  Type of the post. Possible values: text, image, video, audio, gif
     * @bodyParam is_story boolean optional  If post is a story. Default value is false
     */
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
        $post->is_story = $request->is_story ? true : false;
        $post->save();

        return response()->json(Post::find($post->id));
    }

    /**
     * Delete a post
     * @authenticated
     */
    public function destroy(Post $post)
    {
        $deleted = $post->delete();
        $status = $deleted ? 200 : 400;
        return response()->json(null, $status);
    }

    /**
     * Report a post
     * @authenticated
     */
    public function report(Post $post, Request $request)
    {
        $request->validate([
            'message' => 'sometimes|string'
        ]);
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->first();

        $reportMessage = !empty($request->message) ? $request->message : 'Spam';

        $report = new ReportPost();
        $report->message = $reportMessage;
        $report->post_id = $post->id;
        $report->user_profile_id = $profile->id;
        $report->save();
        return $report;
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

        PostHelper::createPostActivity($profile, $post->id, $type);
        return 1; // like or dislike
    }
}
