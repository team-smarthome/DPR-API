<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PegawaiResource extends JsonResource
{
   /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */

    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'nip' => $this->nip ?? null,
            'nama_pegawai' => $this->nama_pegawai ?? null,
            'jenis_kelamin' => $this->jenis_kelamin ?? null,
            'is_active' => $this->is_active ?? null,
            'jabatan_id' => $this->jabatan_id ?? null,
            'nama_jabatan' => $this->jabatan->nama_jabatan ?? null,
            'instansi_id' => $this->jabatan->instansi_id ?? null,
            'nama_instansi' => $this->jabatan->instansi->nama_instansi ?? null,  
            'email' => $this->email ?? null,
            'phone' => $this->phone ?? null,
            'palm_data_id' => $this->palm_data_id ?? null,
            'vein_pattern' => $this->palmData->vein_pattern ?? null,
            'face_id' => $this->face_id ?? null,
            'face_template' => $this->facialData->face_template ?? null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
