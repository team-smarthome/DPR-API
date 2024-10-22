<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;


class GrupPegawaiRequest
{
    public function validate(Request $request)
  {
    $request->merge([
      'nama_grup_pegawai' => trim($request->input('nama_grup_pegawai')),
    ]);

    $rules = [
      'nama_grup_pegawai' => [
        'required',
        'string',
        'max:100',
        Rule::unique('grup_pegawai', 'nama_grup_pegawai')->where(function ($query) {
        return $query->whereNull('deleted_at')
                    ->whereRaw('LOWER(nama_grup_pegawai) = LOWER(?)', [request('nama_grup_pegawai')]);
      }),
        'regex:/^[a-zA-Z\s]*$/'
      ],
      'ketua_grup' => 'required|string|max:100',
      'pegawai.*' => 'nullable|exists:pegawai,id',
    ];

    $messages = [
        'nama_grup_pegawai.required' => 'Nama grup pegawai wajib diisi.',
        'nama_grup_pegawai.string' => 'Nama grup pegawai harus berupa string.',
        'nama_grup_pegawai.max' => 'Nama grup pegawai maksimal 100 karakter.',
        'nama_grup_pegawai.unique' => 'Nama grup pegawai sudah ada.',
        'nama_grup_pegawai.regex' => 'Nama grup pegawai hanya boleh mengandung huruf dan spasi.',
        'ketua_grup.required' => 'Ketua grup wajib diisi.',
        'ketua_grup.string' => 'Ketua grup harus berupa string.',
        'ketua_grup.max' => 'Ketua grup maksimal 100 karakter.',
    ];

    $validator = \Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
