<?php

namespace App\Http\Requests\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ChangePasswordPengunjungRequest
{
  public function validate(Request $request)
  {

    $rules = [
      'pengunjung_id' => 'required|exists:user_pengunjung,pengunjung_id',
      'old_password' => 'required|string',
      'new_password' => 'required|string|min:6|confirmed',
    ];

    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
