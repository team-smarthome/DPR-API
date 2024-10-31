<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;


class WfhPegawaiRequest
{
  public function validate(Request $request)
  {


    $rules = [
      'pegawai_id' => 'string|max:36',
      'nama_wfh_pegawai' => '',
      'waktu_mulai' => 'date',
      'waktu_selesai' => 'date',
      'jumlah_hari' => 'integer',
      'waktu_mulai' => 'required|date',
      'waktu_selesai' => 'nullable|date',
      'image_url' => 'nullable|string',
      'status' => 'string|max:100',
      'keterangan' => 'string|max:100',
      'approved_by_id' => 'string|max:36',
    ];


    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
