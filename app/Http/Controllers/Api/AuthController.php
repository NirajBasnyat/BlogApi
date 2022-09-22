<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use App\Traits\HttpResponse;
use Auth;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use HttpResponse;

    public function login(Request $request): ?JsonResponse
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'email' => 'required|email|exists:users,email',
                    'password' => 'required|min:6|string'
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => 'Response Error',
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => 'Response Error',
                    'message' => 'Email or Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => 'Response Successful',
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Response Error',
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function register(Request $request): ?JsonResponse
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|min:6|confirmed'
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => 'Response Error',
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $user->assignRole('author');

            return response()->json([
                'status' => 'Response Successful',
                'message' => 'User Created Successfully',
                'data' =>  $user,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Response Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'Response Successful',
            'message' => 'Logged-Out Successfully'
        ], 200);

    }
}
