<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WfhPegawaiResource extends JsonResource
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
            'pegawai_id' => $this->pegawai_id,
            'nip' => $this->pegawai->nip ?? null,
            'nama_pegawai' => $this->pegawai->nama_pegawai ?? null,
            'jenis_kelamin' => $this->pegawai->jenis_kelamin ?? null,
            'is_active' => $this->pegawai->is_active ?? null,
            'jabatan_id' => $this->pegawai->jabatan_id ?? null,
            'email' => $this->pegawai->email ?? null,
            'phone' => $this->pegawai->phone ?? null,
            'palm_data_id' => $this->pegawai->palm_data_id ?? null,
            'face_id' => $this->pegawai->face_id ?? null,
            'grup_pegawai_id' => $this->pegawai->grup_pegawai_id ?? null,
            'waktu_mulai' => $this->waktu_mulai,
            'waktu_selesai' => $this->waktu_selesai,
            'jumlah_hari' => $this->jumlah_hari,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
