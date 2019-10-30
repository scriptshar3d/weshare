<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brotzka\DotenvEditor\DotenvEditor as Env;
use Brotzka\DotenvEditor\Exceptions\DotEnvException;

class SettingController extends Controller
{
    public function envList(Request $request)
    {
        $env = new Env();
        return response()->json($env->getContent());
    }

    /**
     * Update env variables.
     *
     * @param Request $request
     * @return mixed
     */
    public function updateEnv(Request $request)
    {
        $env = new Env();
        try {
            $env->changeEnv([
                'FIREBASE_ISS'   => $request->FIREBASE_ISS,
                'ONESIGNAL_APP_ID'   => $request->ONESIGNAL_APP_ID,
                'ONESIGNAL_REST_API'   => $request->ONESIGNAL_APP_ID,
                'APP_TIMEZONE'   => $request->APP_TIMEZONE
            ]);
        } catch (DotEnvException $e) {
        }

        return response()->json([]);
    }

    public function timezoneList()
    {
        return response()->json(timezone_identifiers_list());
    }
}
