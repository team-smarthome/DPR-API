<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ZonaRequest
{
  public function validate(Request $request)
  {
    $request->merge([
      'nama_zona' => trim($request->input('nama_zona')),
    ]);

    $rules = [
      'nama_zona' => [
        'required',
        'string',
        'max:100',
        \Illuminate\Validation\Rule::unique('zona', 'nama_zona')->where(function ($query) {
          return $query->whereRaw('LOWER(nama_zona) = LOWER(?)', [request('nama_zona')]);
        }),
        'regex:/^[a-zA-Z\s]*$/'
      ],
      'jenis_zona' => 'required|string|max:100',
      'lokasi_id' => 'required|uuid',
      'is_deleted' => 'boolean',
      'panjang' => 'required|numeric',
      'lebar' => 'required|numeric',
      'posisi_X' => 'required|numeric',
      'posisi_Y' => 'required|numeric',
      'parent_id' => 'nullable|uuid',
      'jenis_restriksi' => 'nullable|string|max:100'
    ];

    $messages = [
      'nama_zona.required' => 'Nama zona wajib diisi.',
      'nama_zona.string' => 'Nama zona harus berupa string.',
      'nama_zona.max' => 'Nama zona maksimal 100 karakter.',
      'nama_zona.unique' => 'Nama zona sudah ada.',
      'nama_zona.regex' => 'Nama zona hanya boleh mengandung huruf dan spasi.',
      'jenis_zona.required' => 'Jenis zona wajib diisi.',
      'jenis_zona.string' => 'Jenis zona harus berupa string.',
      'jenis_zona.max' => 'Jenis zona maksimal 100 karakter.',
      'lokasi_id.required' => 'Lokasi ID wajib diisi.',
      'lokasi_id.uuid' => 'Lokasi ID harus berupa UUID yang valid.',
      'is_deleted.boolean' => 'Is Deleted harus berupa nilai boolean.',
      'panjang.required' => 'Panjang wajib diisi.',
      'panjang.numeric' => 'Panjang harus berupa angka.',
      'lebar.required' => 'Lebar wajib diisi.',
      'lebar.numeric' => 'Lebar harus berupa angka.',
      'posisi_X.required' => 'Posisi X wajib diisi.',
      'posisi_X.numeric' => 'Posisi X harus berupa angka.',
      'posisi_Y.required' => 'Posisi Y wajib diisi.',
      'posisi_Y.numeric' => 'Posisi Y harus berupa angka.',
      'parent_id.uuid' => 'Parent ID harus berupa UUID yang valid.',
      'jenis_restriksi.string' => 'Jenis restriksi harus berupa string.',
      'jenis_restriksi.max' => 'Jenis restriksi maksimal 100 karakter.',
    ];

    $validator = \Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $validator->validated();
  }
}
