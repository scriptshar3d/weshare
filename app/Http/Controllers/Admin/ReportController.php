<?php

namespace App\Http\Controllers\Admin;

use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use App\Models\Post;
use App\Models\ReportPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Validator;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reports = ReportPost::latest();
        return view('admin.reports.index', ['reports' => $reports->paginate()]);
    }
}
