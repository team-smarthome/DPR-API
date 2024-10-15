<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
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

    return $validator->validated();
  }
}
