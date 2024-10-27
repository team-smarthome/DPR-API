<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DeviceRequest
{
  public function validate(Request $request)
  {
    $data = $request->except(['user_id', 'role_id', 'nama_role']);

    if (isset($data['nama_device'])) {
      // Single item format, wrap in an array
      $data = [$data];
    }
    $rules = [
      '*.nama_device' => 'required|string|max:255',
      '*.zona_id' => 'required|string|max:255',
      '*.dtype' => 'required|string|max:255',
      '*.ip_address' => 'required|string|max:255',
      '*.mac_address' => 'required|string|max:255',
      '*.rtsp_url' => 'required|string|max:255',
      '*.url_cp_device' => 'required|string|max:255',
      '*.username_cp_device' => 'required|string|max:255',
      '*.password_cp_device' => 'required|string|max:255',
      '*.timezone_cp_device' => 'required|string|max:255'
    ];

    $validator = \Validator::make($data, $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
