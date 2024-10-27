<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FacialDataRequest
{
  public function validate(Request $request)
  {
    $data = $request->all();

    if (is_array(reset($data))) {
      $rules = ['*.face_template' => 'required|string'];
    } else {
      $rules = ['face_template' => 'required|string'];
    }

    $validator = \Validator::make($data, $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
