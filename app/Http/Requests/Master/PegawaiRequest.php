<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class PegawaiRequest
{
  public function validate(Request $request)
  {
    $data = $request->all();

    if (is_array(reset($data))) {
      $rules = [
        '*.nip' => 'required|string|max:100',
        '*.nama_pegawai' => 'string|max:100',
        '*.jenis_kelamin' => 'string|max:100',
        '*.is_active' => ['integer', Rule::in([0, 1, 2])],
        '*.nama_jabatan' => 'string|max:100',
        '*.email' => 'string|max:100',
        '*.phone' => 'string|max:100',
        '*.palm_data_id' => 'string|max:36',
        '*.face_id' => 'string|max:36',
        '*.nama_grup_pegawai' => 'max:36',
        '*.role_id' => 'max:36',
      ];
    } else {
      $rules = [
        'nip' => 'required|string|max:100',
        'nama_pegawai' => 'string|max:100',
        'jenis_kelamin' => 'string|max:100',
        'is_active' => ['integer', Rule::in([0, 1, 2])],
        'nama_jabatan' => 'string|max:100',
        'email' => 'string|max:100',
        'phone' => 'string|max:100',
        'palm_data_id' => 'string|max:36',
        'face_id' => 'string|max:36',
        'nama_grup_pegawai' => 'max:36',
        'role_id' => 'max:36',
      ];
    }

    $validator = \Validator::make($data, $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
