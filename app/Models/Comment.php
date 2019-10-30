<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Comment extends Model
{
    use Sortable;

    protected $with = ['post'];

    public function getUserProfileIdAttribute($value)
    {
        return UserProfile::select(['id', 'name','gender'])->find($value);
    }

    public function comment_activities()
    {
        return $this->hasMany('App\Models\CommentActivity');
    }

    public function post()
    {
        return $this->belongsTo('App\Models\Post', 'post_id');
    }
}
