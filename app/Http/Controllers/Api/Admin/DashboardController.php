<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActiveLog;
use App\Models\Auth\User\User;
use App\Models\Post;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;


class DashboardController  extends Controller
{
    public function postTypeSummary(Request $request)
    {
        $postTypeSummary = DB::table('posts')->selectRaw('count(*) as total, type')
            ->whereNotNull('type')
            ->groupBy('type')
            ->get();

        return response()->json([
            "summary" => $postTypeSummary
        ]);
    }

    public function postsAnalytics(Request $request)
    {
        $postsChartData = Post::select(DB::raw('DATE(created_at) as created_at'), DB::raw('count(*) as total'))
            ->whereDate('created_at', '>', Carbon::now()->subDays(7))
            ->whereDate('created_at', '<', Carbon::now())
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        $summary = [
            ["title" => "Total", "value" => Post::whereRaw("1=1")->count()],
            ["title" => "Last Month", "value" => Post::whereDate('created_at', '>', Carbon::now()->subDays(30))->count()],
            ["title" => "Last Week", "value" => Post::whereDate('created_at', '>', Carbon::now()->subDays(7))->count()],
            ["title" => "Today", "value" => Post::whereDate('created_at', '>', Carbon::now())->count()]
        ];

        $chartLabel = array_map([$this, "mapDayName"], $postsChartData->pluck('created_at')->toArray());

        return response()->json([
            "chart" => [
                "chartLabel" => $chartLabel,
                "linesData" => [$postsChartData->pluck("total")]
            ],
            "summary" => $summary
        ]);

    }

    public function userAnalytics(Request $request)
    {
        $usersChartData = UserProfile::select(DB::raw('DATE(created_at) as created_at'), DB::raw('count(*) as total'))
            ->whereDate('created_at', '>', Carbon::now()->subDays(300))
            ->whereDate('created_at', '<', Carbon::now())
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        $chartLabel = array_map([$this, "mapDayName"], $usersChartData->pluck('created_at')->toArray());

        $summary = [
            ["title" => "Total", "value" => UserProfile::whereRaw("1=1")->count()],
            ["title" => "Last Month", "value" => UserProfile::whereDate('created_at', '>', Carbon::now()->subDays(30))->count()],
            ["title" => "Last Week", "value" => UserProfile::whereDate('created_at', '>', Carbon::now()->subDays(7))->count()],
            ["title" => "Today", "value" => UserProfile::whereDate('created_at', '=', Carbon::now())->count()]
        ];

        return response()->json([
            "chart" => [
                "chartLabel" => $chartLabel,
                "linesData" => $usersChartData->pluck("total")
            ],
            "summary" => $summary
        ]);

    }

    public function genderStatistics(Request $request)
    {
        $totalUsers = UserProfile::count();

        $males = UserProfile::where('gender', 'm')->count();
        $females = UserProfile::where('gender', 'f')->count();

        return response()->json(["total" => $totalUsers, "males" => $males, "females" => $females]);
    }

    public function dailyUserAnalytics(Request $request)
    {
        $dailyActiveUsersData = ActiveLog::select(DB::raw('DATE(created_at) as created_at'), DB::raw('count(*) as total'))
            ->whereDate('created_at', '>', Carbon::now()->subDays(7))
            ->whereDate('created_at', '<', Carbon::now())
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        return response()->json([
            "weeks" => array_map([$this, "mapDayName"], $dailyActiveUsersData->pluck('created_at')->toArray()),
            "count" => $dailyActiveUsersData->pluck('total')
        ]);
    }

    private function mapDayName($date) {
        return $date->format("D");
    }
}
