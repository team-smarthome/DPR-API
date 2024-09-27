<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $jwtSecret;

    public function __construct()
    {
        $this->jwtSecret = env('JWT_SECRET', 'your_default_secret');
    }

    public function login(Request $request)
    {
        $loginRequest = new LoginRequest();
        
        $validatedData = $loginRequest->validate($request);

        $user = User::where('username', $validatedData['username'])->first();

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = $this->generateJwt($user);
        return response()->json(compact('token'));
    }

    /**
     * Generate JWT Token
     */
    private function generateJwt($user)
    {
        $payload = [
            'sub' => $user->id, 
            'iat' => time(),
            'exp' => time() + 60 * 60, 
        ];

        return JWT::encode($payload, $this->jwtSecret, 'HS256');
    }
}
