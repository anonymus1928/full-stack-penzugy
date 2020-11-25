<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Parser;

const TOKEN_NAME = 'SuperMaxiToken';

class ApiAuthController extends Controller
{
    /**
     * New user registration
     */
    public function register(Request $request) {
        // Data validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        // If there is an error, return with error code 422 (Unprocessable Entity) and the errors
        if($validator->fails()) {
            return response()->json(['status' => 'error', 'error' => $validator->errors()], 422);
        }

        // No error, create new user, hash password, insert in the users table
        $user = $request->all();
        $user['password'] = Hash::make($user['password']);
        $user = User::create($user);

        // Create token for the new user and return it with 201
        $token = $user->createToken(TOKEN_NAME)->accessToken;
        return response()->json(['status' => 'OK', 'token' => $token], 201);
    }


    /**
     * User login
     */
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        // Check the credentials
        // if OK, then create a token and return it with 200
        // if not, then return with 401
        if(auth()->attempt($credentials)) {
            $token = Auth::user()->createToken(TOKEN_NAME)->accessToken;
            return response()->json(['status' => 'OK', 'token' => $token], 200);
        } else {
            return response()->json(['status' => 'error', 'error' => 'Unauthorised'], 401);
        }
    }


    /**
     * Logout
     */
    public function logout(Request $request) {
        $tokenRepository = app('Laravel\Passport\TokenRepository');
        $tokenId = (new Parser())->parse($request->bearerToken())->getClaims()['jti']->getValue();
        $tokenRepository->revokeAccessToken($tokenId);
        return response()->json(['status' => 'OK']);
    }


    /**
     * Get authenticated user
     */
    public function get_user() {
        $user = Auth::user();
        return response()->json(['status' => 'OK', 'user' => $user], 200);
    }
}
