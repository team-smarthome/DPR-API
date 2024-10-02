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

    ];


    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
