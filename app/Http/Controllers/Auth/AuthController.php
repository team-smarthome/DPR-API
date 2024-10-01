<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\UserLogin;
use Illuminate\Support\Carbon;
use App\Models\UserLog;


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

        try {
            $validatedData = $loginRequest->validate($request);
            $user = User::with('role')->where('username', $validatedData['username'])->first();

            if (!$user || !Hash::check($validatedData['password'], $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Unauthorized'
                ], 401);
            }


            if ($user->is_suspend == 1) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Unauthorized. User is suspended.'
                ], 401);
            }

            $token = $this->generateJwt($user);

             DB::transaction(function () use ($user) {
                $token = $this->generateJwt($user);

                UserLogin::create([
                    'user_id' => $user->id,
                    'token' => $token,
                    'token_expired' => Carbon::now()->addHour(),
                ]);

                UserLog::create([
                    'id' => \Illuminate\Support\Str::uuid(),
                    'user_id' => $user->id,
                    'nama_user_log' => 'Login',
                ]);
            });

            return response()->json([
                'status' => 200,
                'token' => $token
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate JWT Token
     */
    private function generateJwt($user)
    {
        $payload = [
            'sub' => $user->id,
            'pegawai_id' => $user->pegawai_id,
            'iat' => time(),
            'exp' => time() + 60 * 60,
            'role_id' => $user->role_id,
            'nama_role' => $user->role->nama_role,
        ];

        return JWT::encode($payload, $this->jwtSecret, 'HS256');
    }
}
