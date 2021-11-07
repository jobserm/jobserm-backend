<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function __construct() {
//        $this->middleware('auth:api');
//    }

    public function index()
    {
//        $this->authorize('viewAny', User::class);
        return User::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
//        $this->authorize('view', $user);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', User::class); // be right back

        // update user

        return "update succesfully";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function firstRegister(Request $request, User $user) {

        $this->authorize('update', $user);

        $validator = Validator::make($request->all(), [
            'birthdate' => ['required', 'string', 'regex:/^[0-9]{4}-[0-9]{2}-[0-9]{2}/'],
//            'gender' => ['required', 'string'],
            // role,
            'address' => ['required', 'string'],
            'facebook' => ['string'],
            'line' => ['string'],
            'about_me' => ['required', 'string'],
            'skill' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user->birthdate = $request->input('birthdate');
        // $user->gender = $request->input('gender');
        $user->address = $request->input('address');
        $user->facebook = $request->input('facebook');
        $user->line = $request->input('line');
        $user->about_me = $request->input('about_me');
        $user->skill = $request->input('skill');
        $user->is_publish = $request->input('is_publish') || 0;

        $user->save();

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function toggleActivation(Request $request, User $user) {

        $this->authorize('update', $user);

        $user->activation = $user->activation === 1 ? 0 : 1;
        $user->save();

        return response()->json([
            'message' => 'Successfully activate/deactivate account'
        ]);
    }

    public function getUserIsPublish() {
        $users = User::get()->where('is_publish', 1);
        return UserResource::collection($users);
    }
}
