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
      'nama_kunjungan' => $this->nama_kunjungan ?? null,
      'keperluan' => $this->keperluan ?? null,
      'is_approved' => $this->is_approved ?? null,
      'pending_date' => $this->is_approved == 0 ? Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null,
      'approved_date' => $this->is_approved == 1 ? Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null,
      'reject_date' => $this->is_approved == 2 ? Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null,
      'approved_by_id' => $this->approved_by_id ?? null,
      'approved_by' => $this->pegawai->nama_pegawai ?? null,
      'waktu_mulai' => $this->waktu_mulai ?? null,
      'waktu_berakhir' => $this->waktu_berakhir ?? null,
      'status' => $this->status ?? null,
      'pegawai_tujuan_id' => $this->pegawai_tujuan_id ?? null,
      'nama_pegawai_tujuan' => $this->pegawai->nama_pegawai ?? null,
      'pengunjung' => PengunjungResource::collection($this->pengunjung) ?? [],
    ];
  }
}
