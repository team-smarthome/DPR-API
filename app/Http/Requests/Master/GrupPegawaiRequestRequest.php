<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GrupPegawaiRequestRequest extends FormRequest
{
    public function validate(Request $request)
    {

        $rules = [
            'ketua_grup' => [
                'required',
                'string',
                'max:255'
            ],
            'nama_grup_pegawai' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('grup_pegawai', 'nama_grup_pegawai')->where(function ($query) {
                    return $query->whereRaw('LOWER(nama_grup_pegawai) = LOWER(?)', [request('nama_grup_pegawai')]);
                }),
                'regex:/^[a-zA-Z\s]*$/'
            ],
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
