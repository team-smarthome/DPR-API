<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use App\Models\UserLogin;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized. Token not provided.'
            ], 401);
        }

        try {
            $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
            
            $request->merge(['user_id' => $credentials->pegawai_id]);

            $userLogin = UserLogin::where('user_id', $credentials->sub)
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$userLogin || $userLogin->token !== $token) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Unauthorized. Token mismatch.'
                ], 401);
            }

            if ($role === 'admin' && !in_array($credentials->nama_role, ['admin', 'super-admin'])) {
                return response()->json([
                    'status' => 403,
                    'message' => 'Forbidden. Access restricted to admins.'
                ], 403);
            } elseif ($role === 'super-admin' && $credentials->nama_role !== 'super-admin') {
                return response()->json([
                    'status' => 403,
                    'message' => 'Forbidden. Access restricted to super admins only.'
                ], 403);
            } 

            return $next($request);
        } catch (ExpiredException $e) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized. Token has expired.' ,
                'error' => $e->getMessage()
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal Server Error.',
                'error' => $e->getMessage()
            ], 401);
        }
    }
}
