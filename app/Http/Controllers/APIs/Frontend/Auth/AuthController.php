<?php

namespace App\Http\Controllers\APIs\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\Resource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * @author Md. Shohag Hossain <mdshohaghossain8080@gmail.com>
 * @since 17.04.2025
 */
class AuthController extends Controller
{
    /**
     * register function
     *
     * @param  Request  $request
     * @return json
     */
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        if ($validation->fails()) {
            $msg = collect($validation->errors()->messages())->flatten()->filter()->values()->toArray();
            return (new ErrorResource($msg, 'Please enter your valid info!', 400))->response()->setStatusCode(400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return (new Resource($user, 'You are successfully register!', 201))->response()->setStatusCode(200);
    }

    /**
     * login function
     *
     * @param  Request  $request
     * @return json
     */
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validation->fails()) {
            $msg = collect($validation->errors()->messages())->flatten()->filter()->values()->toArray();
            return (new ErrorResource($msg, 'Please enter your valid info!', 400))->response()->setStatusCode(400);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $user->token = $user->createToken('authToken')->accessToken;

        return (new Resource($user, 'You are successfully login!', 201))->response()->setStatusCode(200);
    }

    /**
     * normal logout
     *
     * @param  Request  $request
     * @return json
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return (new Resource([], 'Successfully logged out!', 200))->response()->setStatusCode(200);
    }

    /**
     * logout from all device
     *
     * @param  Request  $request
     * @return json
     */
    public function logoutFromAllDevice(Request $request)
    {
        $request->user()->tokens()->delete(); // Revokes all tokens

        return (new Resource([], 'Successfully logged out!', 200))->response()->setStatusCode(200);
    }
}
