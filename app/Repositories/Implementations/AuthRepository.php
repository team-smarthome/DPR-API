<?php

namespace App\Repositories\Implementations;

use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthRepository implements AuthRepositoryInterface
{
    public function login(array $credentials)
    {
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return ['status' => 401, 'message' => 'Invalid credentials'];
            }
        } catch (JWTException $e) {
            return ['status' => 500, 'message' => 'Could not create token'];
        }

        return ['status' => 200, 'token' => $token];
    }
}
