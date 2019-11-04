<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class FollowRequest extends Model
{
    protected $fillable = ['user_profile_id', 'requested_by_profile_id'];
    protected $with = ['profile', 'requested_by'];

    public function profile()
    {
        return $this->belongsTo('App\Models\UserProfile', 'user_profile_id');
    }

    public function requested_by()
    {
        return $this->belongsTo('App\Models\UserProfile', 'requested_by_profile_id');
    }
}
