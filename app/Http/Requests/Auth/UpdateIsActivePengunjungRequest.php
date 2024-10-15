<?php

namespace App\Http\Requests\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateIsActivePengunjungRequest
{
  public function validate(Request $request)
  {
    $rules = [
      'is_active' => ['required', 'integer', Rule::in([0, 1, 2])],
    ];

    $validator = app('validator')->make($request->all(), $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
