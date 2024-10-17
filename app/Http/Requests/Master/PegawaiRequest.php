<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;


class PegawaiRequest
{
  public function validate(Request $request)
  {

    $rules = [
      'nip' => 'string|max:100',
      'nama_pegawai' => 'string|max:100',
      'jenis_kelamin' => 'string|max:100',
      'is_active' => ['integer', Rule::in([0, 1, 2])],
      'jabatan_id' => 'string|max:36',
      'email' => 'string|max:100',
      'phone' => 'string|max:100',
      'palm_data_id' => 'string|max:36',
      'face_id' => 'string|max:36',
      'grup_pegawai_id' => 'max:36',
      'role_id' => 'max:36',
    ];


    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
