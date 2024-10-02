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
        'nip' => 'string|max:100',
        'pegawai_id' => 'string|max:36',
        'pengunjung_id' => 'string|max:36',
        'plat_nomor' => 'string|max:100',
        'image_url' => 'integer',
        'grup_vehicle_pegawai_id' => 'string|max:36',
    ];

    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}

