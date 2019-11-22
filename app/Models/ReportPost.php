<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ReportPost extends Model
{
    protected $table = 'report_posts';

    protected $fillable = ['message', 'user_profile_id', 'post_id'];

    protected $with = array('post', 'userprofile');

    public function userprofile()
    {
        return $this->belongsTo('App\Models\UserProfile', 'user_profile_id');
    }

    public function post()
    {
        return $this->belongsTo('App\Models\Post',  'post_id');
    }
}
