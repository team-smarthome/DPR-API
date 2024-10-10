<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class KunjunganResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'nama_kunjungan' => $this->nama_kunjungan,
      'keperluan' => $this->keperluan,
      'is_approved' => $this->is_approved,
      'pending_date' => $this->is_approved == 0 ? Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null,
      'approved_date' => $this->is_approved == 1 ? Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null,
      'reject_date' => $this->is_approved == 2 ? Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null,
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
