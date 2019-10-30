<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Overtrue\LaravelFollow\Traits\CanFollow;
use Overtrue\LaravelFollow\Traits\CanBeFollowed;

class UserProfile extends Model
{
    use Sortable, CanFollow, CanBeFollowed;

    protected $fillable = [
        'user_id', 'name', 'image', 'gender', 'fcm_registration_id', 'notification_on_like',
        'notification_on_dislike', 'notification_on_comment', 'is_admin', 'is_blocked'
    ];

    protected $casts = [
        'notification_on_like' => 'boolean',
        'notification_on_dislike' => 'boolean',
        'notification_on_comment' => 'boolean'
    ];
    public function activities()
    {
        return $this->hasManyThrough('App\Models\PostActivity', 'App\Models\Post', 'user_profile_id', 'post_id');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    public function followers()
    {
        return $this->hasMany('Overtrue\LaravelFollow\FollowRelation', 'followable_id');
    }

    public function following()
    {
        return $this->hasMany('Overtrue\LaravelFollow\FollowRelation', 'user_profile_id');
    }
}
