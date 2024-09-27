<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class JabatanRequest
{
    public function validate(Request $request)
    {
        $rules = [
            'nama_jabatan' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('jabatan', 'nama_jabatan')->where(function ($query) {
                    return $query->whereRaw('LOWER(nama_jabatan) = LOWER(?)', [request('nama_jabatan')]);
                }),
                'regex:/^[a-zA-Z\s]*$/'
            ],
            'instansi_id' => 'required|string|max:255',
        ];


        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
