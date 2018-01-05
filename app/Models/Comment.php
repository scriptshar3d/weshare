<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Comment extends Model
{
    use Sortable;

    public function getUserProfileIdAttribute($value)
    {
        return UserProfile::select(['id', 'name','gender'])->find($value);
    }

    public function comment_activities()
    {
        return $this->hasMany('App\Models\CommentActivity');
    }
}
