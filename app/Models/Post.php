<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Post extends Model
{
    use Sortable;
    public function getUserProfileIdAttribute($value)
    {
        return UserProfile::select(['id', 'name','gender'])->find($value);
    }

    public function post_activities()
    {
        return $this->hasMany('App\Models\PostActivity');
    }
}
