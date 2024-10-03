<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SmartLockerCompartmentRequest
{
  public function validate(Request $request)
  {

    $rules = [
      "device_id" => 'required|string|max:36',
      'number' => 'required|integer',
      'is_available' => 'required|integer|in:0,1',
      'qr_image' => 'string',
    ];

    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
