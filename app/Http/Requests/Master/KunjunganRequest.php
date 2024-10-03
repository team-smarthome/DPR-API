<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;


class KunjunganRequest
{
  public function validate(Request $request)
  {


    $rules = [
      'nama_kunjungan' => 'required|string|max:36',
      'keperluan' => 'required|string|max:100',
      'is_approved' => 'integer|in:0,1',
      'approved_date' => 'nullable|date',
      'reject_date' => 'nullable|date',
      'approved_by_id' => 'string|max:36',
      'waktu_mulai' => 'date',
      'waktu_berakhir' => 'date',
      'status' => 'string|max:100',
      'pegawai_tujuan_id' => 'string|max:36',
      'pengunjung_id' => 'string|max:36',
    ];


    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
