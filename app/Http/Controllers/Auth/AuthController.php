<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Firebase\JWT\JWT;
use App\Models\UserLog;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

    public function changePassword(Request $request)
    {
        try {
            $username = $request->input('username');
            $oldPassword = $request->input('old_password');
            $newPassword = $request->input('new_password');

            $validator = Validator::make($request->all(), [
                'username' => 'required|string',
                'old_password' => 'required|string',
                'new_password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->errors(),
                ], 422);
            }

            $user = User::where('username', $username)->first();

            if (!$user) {
                return response()->json([
                    'status' => 404,
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            if (!Hash::check($oldPassword, $user->password)) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Password lama salah'
                ], 422);
            }

            $user->password = Hash::make($newPassword);
            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'Password berhasil diperbarui'
            ], 200);

        } catch (\Throwable $th) {
            return $th;
        }
    }
}
