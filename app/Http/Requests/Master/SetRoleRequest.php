<?php

namespace App\Http\Requests\Master;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SetRoleRequest
{
  public function validate(Request $request)
  {
    $rules = [
      'roleId' => 'string|max:36',
    ];

    $validator = app('validator')->make($request->all(), $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
