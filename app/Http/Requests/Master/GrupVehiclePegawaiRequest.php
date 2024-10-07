<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;


class GrupVehiclePegawaiRequest
{
    public function validate(Request $request)
  {
    $request->merge([
      'nama_grup_vehicle_pegawai' => trim($request->input('nama_grup_vehicle_pegawai')),
    ]);

    $rules = [
      'vehicle_id' => 'string|max:100',
      'nama_grup_vehicle_pegawai' => 'required|string|max:100',
    ];

    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
