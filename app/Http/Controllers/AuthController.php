<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponseTrait;

    /**
     * Authenticate user and generate token.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token       = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        $data = new UserResource($user);
        return $this->apiResponse($data, $token, 'User Login successfully', 200);
    }

    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'email'    => $request->email,
            'name'     => $request->name,
            'password' => $request->password
        ]);

        $token = Auth::login($user);
        $data = new UserResource($user);
        return $this->apiResponse($data, $token, 'User Register successfully', 201);
    }

    /**
     * Logout the authenticated user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    /**
     * Change user's password.
     *
     * @param ChangePasswordRequest $request The request object containing the password change data.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the result of the password change operation.
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user_id = Auth::user()->id;
        $user    = User::find($user_id);

        if (!(Hash::check($request->current_password, $user->password))) {

            return response()->json([
                'message'  =>  'Current password is incorrect'
            ], 422);
        }
        $user->update([
            'password' => $request->new_password
        ]);

        return response()->json([
            'message'  =>  'Password Changed Successfully'
        ], 200);
    }
}
