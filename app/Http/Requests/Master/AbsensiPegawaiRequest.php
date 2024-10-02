<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;


class AbsensiPegawaiRequest
{
    public function validate(Request $request)
  {


    $rules = [
        'pegawai_id' => 'string|max:36',
        'nama_absensi_pegawai' => '',
        'is_wfh' => 'integer',
        'image_url' => 'string',

    ];


    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
