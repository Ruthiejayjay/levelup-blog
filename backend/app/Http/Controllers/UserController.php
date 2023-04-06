<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, options: ['except' => ['store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        if ($request->file('avatar')) {
            $path = $request->file('avatar')->store('images', ['disk' => 'public']);
            if (!$path) {
                return response()->json(['msg' => 'avatar could not be saved'], 500);
            }
            $validated['avatar_path'] = $path;
        }


        $user = new User($validated);

        if (!$user->save()) {
            return response()->json(['msg' => "cannot save user"], 500);
        }


        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load('articles');
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        if ($request->avatar) {
            $path = $request->file('avatar')->store('images', ['disk' => 'public']);
            if (!$path) {
                return response()->json(['msg' => 'avatar could not be saved'], 500);
            }
            $validated['avatar_path'] = $path;
        }
        if (!$user->save()) {
            return response()->json(['msg' => "cannot update user"], 500);
        }

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            return response()->noContent();
        }
    }
}
