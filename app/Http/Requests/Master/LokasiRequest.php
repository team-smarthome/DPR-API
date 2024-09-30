<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LokasiRequest
{
  public function validate(Request $request)
  {
    $request->merge([
      'nama_lokasi' => trim($request->input('nama_lokasi')),
    ]);

    $rules = [
      'nama_lokasi' => [
        'required',
        'string',
        'max:100',
        \Illuminate\Validation\Rule::unique('lokasi', 'nama_lokasi')->where(function ($query) {
          return $query->whereRaw('LOWER(nama_lokasi) = LOWER(?)', [request('nama_lokasi')]);
        }),
        'regex:/^[a-zA-Z\s]*$/'
      ],
      'latitude' => 'required|numeric',
      'longitude' => 'required|numeric'
    ];

    $messages = [
      'nama_lokasi.required' => 'Nama lokasi wajib diisi.',
      'latitude.required' => 'Latitude lokasi wajib diisi.',
      'longitude.required' => 'Longitude lokasi wajib diisi.'
    ];

    $validator = \Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
