<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AbsensiPegawaiResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */

  public function toArray(Request $request)
  {
    // Define the reference time as 09:00
    $referenceTime = Carbon::createFromTime(9, 0, 0);

    // Parse waktu_mulai as Carbon instance
    $waktuMulai = $this->waktu_mulai ? Carbon::parse($this->waktu_mulai) : null;

    // Determine the keterangan based on waktu_mulai
    $keterangan = null;
    if ($waktuMulai) {
      if ($waktuMulai->lte($referenceTime)) {
        $keterangan = 'Tepat Waktu';
      } else {
        // Calculate delay in minutes and hours
        $delayMinutes = $referenceTime->diffInMinutes($waktuMulai);
        $hoursLate = intdiv($delayMinutes, 60);
        $minutesLate = $delayMinutes % 60;

        // Format keterangan based on delay
        if ($hoursLate > 0) {
          $keterangan = "Terlambat $hoursLate jam $minutesLate menit";
        } else {
          $keterangan = "Terlambat $minutesLate menit";
        }
      }
    }

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
      'image_url' => $this->image_url,
      'keterangan' => $keterangan,  // Add calculated keterangan to the response
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at
    ];
  }
}
