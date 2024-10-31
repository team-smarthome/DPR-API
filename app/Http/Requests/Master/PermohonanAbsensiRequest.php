<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PermohonanAbsensiRequest
{
  public function validate(Request $request)
  {

    $rules = [
      'pegawai_id' => 'required|string|max:36',
      'nama_permohonan' => 'required|string|max:100',
      'jenis_permohonan' => 'string|max:100',
      'image_lampiran' => 'nullable|string',
      'status' => 'nullable|string',
      'jumlah_hari' => 'integer',
      'keterangan' => 'nullable|string',
      'waktu_mulai' => 'required|date',
      'waktu_selesai' => 'nullable|date',
      'approved_by_id' => 'nullable|string|max:36',
    ];


    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
