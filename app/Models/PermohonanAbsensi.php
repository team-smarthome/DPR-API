<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermohonanAbsensi extends Model
{
  use SoftDeletes, HasUuids;
  protected $table = 'permohonan_absensi';

  protected $fillable = [
    'pegawai_id',
    'nama_permohonan',
    'status',
    'image_lampiran',
    'waktu_mulai',
    'waktu_selesai',
    'jumlah_hari',
    'keterangan',
    'jenis_permohonan',
    'approved_by_id'
  ];

  public function pegawai()
  {
    return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
  }
}
