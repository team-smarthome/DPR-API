<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginPengunjungRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\LoginPengunjung;
use App\Models\UserPengunjung;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginPengunjungController extends Controller
{
  public function login(Request $request)
  {
    $loginPengunjungRequest = new LoginPengunjungRequest();
    $validatedData = $loginPengunjungRequest->validate($request);
    // Mencari user berdasarkan username
    $user = UserPengunjung::where('username', $validatedData['username'])->first();

    if (!$user || !Hash::check($validatedData['password'], $user->password)) {
      return response()->json([
        'status' => 401,
        'message' => 'Username atau password salah',
      ], 401);
    }

    // Update last_login
    $user->last_login = Carbon::now();
    $user->save();

    return response()->json([
      'status' => 200,
      'message' => 'Login berhasil',
      'user' => [
        'id' => $user->id,
        'username' => $user->username,
        'last_login' => $user->last_login,
      ],
    ]);
  }
}
