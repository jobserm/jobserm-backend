<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = JWTAuth::attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'user' => auth()->user()
        ]);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'lastname' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'string', 'regex:/^[0-9]{4}-[0-9]{2}-[0-9]{2}/'],
            'gender' => ['required', 'string'],
            // role,
            'phone' => ['required', 'string', 'min:9', 'max:10', 'regex:/^0[0-9]{9}/'],
            'address' => ['required', 'string'],
            'facebook' => ['string'],
            'line' => ['string'],
            'username' => ['required', 'string', 'unique:App\Models\User,username'],
            'about_me' => ['required', 'string'],
            'skill' => ['required', 'string']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

//        $user = User::create(array_merge(
//            $validator->validated(),
//            ['password' => bcrypt($request->password)]
//        ));
        $user = new User();
        $user->name = $request->input("name");
        $user->email = $request->input("email");
        $user->password = Hash::make($request->input("password"));
//        $user->password_confimation = Hash::make($request->input("password"));
        $user->lastname = $request->input("lastname");
        $user->birthdate = $request->input("birthdate");
        $user->gender = $request->input('gender');
        $user->phone = $request->input("phone");
        $user->address = $request->input("address");
        $user->facebook = $request->input("facebook");
        $user->line = $request->input("line");
        $user->username = $request->input("username");
        $user->about_me = $request->input("about_me");
        $user->skill = $request->input("skill");

        $user->save();

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        $user = JWTAuth::user();
        return response()->json($user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        return $this->respondWithToken(auth()->refresh());
    }
}
