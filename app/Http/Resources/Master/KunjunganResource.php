<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class KunjunganResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'nama_kunjungan' => $this->nama_kunjungan,
      'keperluan' => $this->keperluan,
      'is_approved' => $this->is_approved,
      'approved_date' => $this->approved_date,
      'reject_date' => $this->reject_date,
      'approved_by_id' => $this->approved_by_id,
      'approved_by' => $this->pegawai->nama_pegawai,
      'waktu_mulai' => $this->waktu_mulai,
      'waktu_berakhir' => $this->waktu_berakhir,
      'status' => $this->status,
      'pegawai_tujuan_id' => $this->pegawai_tujuan_id,
      'nama_pegawai_tujuan' => $this->pegawai->nama_pegawai,
      'pengunjung' => PengunjungResource::collection($this->pengunjung),
    ];
  }
}
