<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use App\Models\UserLogin; // Pastikan untuk mengimpor model UserLogin

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
    public function handle($request, Closure $next, $guard = null)
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

            $userLogin = UserLogin::where('user_id', $credentials->sub)
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$userLogin || $userLogin->token !== $token) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Unauthorized. Token mismatch.'
                ], 401);
            }

        } catch (ExpiredException $e) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized. Token has expired.'
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized. Invalid token.'
            ], 401);
        }

        return $next($request);
    }
}
