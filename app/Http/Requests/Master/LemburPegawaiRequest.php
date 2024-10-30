<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LemburPegawaiRequest
{
  public function validate(Request $request)
  {

    $rules = [
      'pegawai_id' => 'required|string|max:36',
      'nama_absensi_pegawai' => 'required|string|max:100',
      'jenis' => 'string',
      'image_url' => 'nullable|string',
      'status' => 'nullable|string',
      'keterangan' => 'nullable|string',
      'waktu_masuk' => 'required|date',
      'waktu_keluar' => 'nullable|date',
      'approved_by_id' => 'nullable|string|max:36',
    ];


    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
