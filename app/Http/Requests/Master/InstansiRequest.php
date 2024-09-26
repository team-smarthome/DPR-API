<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstansiRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'nama_instansi' => ['required', 'string', 'max:100'],
    ];
  }

  public function messages()
  {
    return [
      'nama_instansi.required' => 'Username wajib diisi',
    ];
  }
}
