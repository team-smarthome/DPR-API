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
        $this->jwtSecret = env('JWT_SECRET', 'testing1234');
    }

    public function login(Request $request)
    {
        $loginRequest = new LoginRequest();
        
        $validatedData = $loginRequest->validate($request);

        $user = User::with('role')->where('username', $validatedData['username'])->first();

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response()->json(
                [
                    'status' => 401,
                    'message' => 'Unauthorized'
                ],
                401
            );
        }

        $token = $this->generateJwt($user);

        return response()->json([
            'status' => 200,
            'token' => $token
        ], 200);
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
            'role_id' => $user->role_id,
            'nama_role' => $user->role->nama_role,
        ];

        return JWT::encode($payload, $this->jwtSecret, 'HS256');
    }
}
