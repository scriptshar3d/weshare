<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auth\User\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::whereRaw("1=1");

        return response()->json($users->orderBy('created_at', 'asc')->paginate(config('constants.paginate_per_page')));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  User  $user
     * @param  \Illuminate\Http\Request  $request     
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255'
        ]);

        $validator->sometimes('email', 'unique:users', function ($input) use ($user) {
            return strtolower($input->email) != strtolower($user->email);
        });

        $validator->sometimes('password', 'min:6', function ($input) {
            return $input->password;
        });

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->name = $request->get('name');
        $user->email = $request->get('email');        

        if ($request->has('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        $user->save();
        
        return response()->json($user);
    }
}
