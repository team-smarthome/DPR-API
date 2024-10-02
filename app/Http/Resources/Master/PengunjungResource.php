<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class PengunjungResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'nik' => $this->nik,
      'nama_pengunjung' => $this->nama_pengunjung,
      'jenis_kelamin' => $this->jenis_kelamin,
      'is_active' => $this->is_active,
      'email' => $this->email,
      'phone' => $this->phone,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
      'palm_data_id' => $this->palm_data_id,
      'face_id' => $this->face_id
    ];
  }
}
