<?php

namespace App\Http\Requests\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class UserPengunjungRequest
{
  public function validate(Request $request)
  {
    $rules = [
      'pengunjung_id' => 'required|string|uuid|max:36',
      'username' => 'required|string|max:100',
      'password' => 'required|string|min:6',
      'role_id' => 'required|string|uuid|max:36',
      'is_deleted' => 'sometimes|boolean',
      'is_suspend' => 'sometimes|boolean',
      'last_login' => 'sometimes|date',
    ];

    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    $validated = $validator->validated();

    // Hash the password
    $validated['password'] = Hash::make($validated['password']);

    return $validated;
  }
}
