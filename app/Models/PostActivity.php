<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class PostActivity extends Model
{
    use Sortable;

    public function getUserProfileIdAttribute($value)
    {
        return UserProfile::select(['id', 'name','gender'])->find($value);
    }

    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }
}
