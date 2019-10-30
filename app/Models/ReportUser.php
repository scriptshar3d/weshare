<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class ReportUser extends Model
{
    protected $table = 'report_users';

    protected $fillable = ['message', 'user_profile_id', 'reported_by'];

    protected $with = array('reporter', 'userprofile');

    public function userprofile()
    {
        return $this->belongsTo('App\Models\UserProfile', 'user_profile_id');
    }

    public function reporter()
    {
        return $this->belongsTo('App\Models\UserProfile',  'reported_by');
    }
}
