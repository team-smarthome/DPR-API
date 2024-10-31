<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class PermohonanAbsensiResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'nama_permohonan' => $this->nama_permohonan,
      'pegawai' => $this->pegawai,
      'image_lampiran' => $this->image_lampiran,
      'jenis_permohonan' => $this->jenis_permohonan,
      'waktu_mulai' => $this->waktu_mulai,
      'waktu_selesai' => $this->waktu_selesai,
      'keterangan' => $this->keterangan,
      'status' => $this->status ?? null,
      'jumlah_hari' => $this->jumlah_hari,
      'approved_by_id' => $this->approved_by_id ?? null,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at
    ];
  }
}
