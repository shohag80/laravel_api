<?php

namespace App\Http\Controllers\APIs\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\Resource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * @author Md. Shohag Hossain <mdshohaghossain8080@gmail.com>
 * @since 17.04.2025
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return (new Resource($request->user(), 'Data fatch Successfully!', 200))->response()->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        return (new Resource($user, 'You are successfully register!', 201))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::where('id', $id)->first();

        if ($user == null) {
            return (new ErrorResource($user, "Requested data not found!", 404))->response()->setStatusCode(404);
        }

        try {
            $update_data = $user->update([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => bcrypt($request->password),
            ]);
            $user->update_status = $update_data;

            return (new Resource($user, "User data updated successfully!", 200))->response()->setStatusCode(200);
        } catch (\Throwable $th) {
            //throw $th;
            return (new ErrorResource($th->getMessage(), "Oops! Something want wrong! Please, try again.", 500))->response()->setStatusCode(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('id', $id)->first();

        if ($user == null) {
            return (new ErrorResource($user, "Requested data not found!", 404))->response()->setStatusCode(404);
        }

        try {
            $user->update([
                'active_status' => 0,
            ]);

            return (new Resource([], "User data deleted successfully!", 200))->response()->setStatusCode(200);
        } catch (\Throwable $th) {
            //throw $th;
            return (new ErrorResource([], "Oops! Something want wrong! Please, try again.", 500))->response()->setStatusCode(500);
        }
    }
}
