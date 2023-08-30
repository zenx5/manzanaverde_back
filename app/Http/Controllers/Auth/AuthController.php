<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = false;
        try{
            $validate = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required',
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'error' => false,
                'user' => $user,
                'token' => $token
            ], 201);
        } catch(Illuminate\Validation\ValidationException $error) {
            return response()->json([
                'error' => true,
                'message' => 'Validation failed'
            ], 400);
        }
        finally {
            if( !$validate ) {
                return response()->json([
                    'error' => true,
                    'message' => 'Validation failed'
                ], 400);
            }
        }
    }

    public function login(Request $request)
    {
        $validate = false;
        try{
            $validate = $request->validate([
                'email' => 'required|string|email|max:255',
                'password' => 'required',
            ]);
            $credentials = $request->only(['email', 'password']);
            $token = JWTAuth::attempt($credentials);
            if ( ! $token ) {
                return response()->json([
                    'error' => true,
                    'message' => 'Unauthorized'
                ], 401);
            }
            return response()->json([
                'error' => false,
                'token' => $token], 200);
        } catch( Exception $error ) {
            return response()->json([
                'error' => true,
                'message' => $error->getMessage()
            ], 400);
        }
        finally {
            if( !$validate ) {
                return response()->json([
                    'error' => true,
                    'message' => 'Validation failed .'
                ], 400);
            }
        }
    }

    public function logout(Request $request)
    {
        return response()->json([
            'token' => $request->token
        ], 200);
        try{
            JWTAuth::invalidate($request->token);
            return response()->json([
                'error' => false,
                'message' => 'User logged out successfully'
            ], 200);
        } catch( Exception $error ) {
            return response()->json([
                'error' => true,
                'message' => $error->getMessage()
            ], 400);
        }
    }
}
