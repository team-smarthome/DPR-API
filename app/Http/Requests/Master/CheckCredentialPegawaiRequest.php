<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CheckCredentialPegawaiRequest
{
  public function validate(Request $request)
  {
    $rules = [
      'user_id' => 'required|string|max:36',
      'username' => 'required|string',
      'password' => 'required|string',
    ];

    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
