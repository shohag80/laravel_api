<?php

namespace App\Http\Controllers\APIs\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Resource;
use Illuminate\Http\Request;

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
