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
      'approved_by' => $this->approved_by,
      'waktu_mulai' => $this->waktu_mulai,
      'waktu_berakhir' => $this->waktu_berakhir,
      'status' => $this->status,
      'pegawai_tujuan' => $this->pegawai_tujuan,
      'pengunjung_id' => $this->pengunjung_id,
    ];
  }
}
