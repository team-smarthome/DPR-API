<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DinasKeluarPegawaiRequest
{
  public function validate(Request $request)
  {

    $rules = [
      'pegawai_id' => 'required|string|max:36',
      'nama_dinas_keluar' => 'required|string|max:100',
      'image_url' => 'nullable|string',
      'status' => 'nullable|string',
      'jumlah_hari' => 'integer',
      'keterangan' => 'nullable|string',
      'waktu_mulai' => 'required|date',
      'waktu_selesai' => 'nullable|date',
      'approved_by_id' => 'nullable|string|max:36',
      'lokasi_dinas' => 'required|string|max:100',
    ];


    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
