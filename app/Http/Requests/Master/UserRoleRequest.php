<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;


class UserRoleRequest
{
  public function validate(Request $request)
  {

    $rules = [
      'nama_role' => 'required|string|max:100',
    ];

    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
