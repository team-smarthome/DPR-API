<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;


class VehicleRequest
{
    public function validate(Request $request)
  {

    $rules = [
        'pegawai_id' => '',
        'pengunjung_id' => '',
        'plat_nomor' => 'string|max:100',
        'image_url' => 'string',
        'grup_vehicle_pegawai_id' => '',
    ];

    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}

