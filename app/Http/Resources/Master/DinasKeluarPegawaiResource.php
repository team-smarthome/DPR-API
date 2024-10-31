<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class DinasKeluarPegawaiResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'nama_dinas_keluar' => $this->nama_dinas_keluar,
      'pegawai' => $this->pegawai,
      'image_url' => $this->image_url,
      'waktu_mulai' => $this->waktu_mulai,
      'waktu_selesai' => $this->waktu_selesai,
      'keterangan' => $this->keterangan,
      'status' => $this->status ?? null,
      'jumlah_hari' => $this->jumlah_hari,
      'lokasi_dinas' => $this->lokasi_dinas,
      'approved_by_id' => $this->approved_by_id ?? null,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at
    ];
  }
}
