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
                'password' => 'required|confirmed',
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
                'message' => 'Validation failed: '.$error.getMessage()
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
            $user = User::where('email', $request->email)->first();
            unset($user->email_verified_at);
            return response()->json([
                'error' => false,
                'user' => $user,
                'token' => $token
            ], 200);
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
        try{
            if( !$request->bearerToken() ) {
                return response()->json([
                    'error' => true,
                    'message' => 'Token not found'
                ], 401);
            }else {
                JWTAuth::manager()->invalidate( new \Tymon\JWTAuth\Token($request->bearerToken()) );
                return response()->json([
                    'error' => false,
                    'message' => 'User logged out successfully'
                ], 200);
            }
        } catch( Exception $error ) {
            return response()->json([
                'error' => true,
                'message' => $error->getMessage()
            ], 400);
        }
    }

}
