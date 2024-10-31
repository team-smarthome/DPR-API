<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DinasKeluarPegawai extends Model
{
  use SoftDeletes, HasUuids;
  protected $table = 'dinas_keluar_pegawai';

  protected $fillable = [
    'pegawai_id',
    'nama_dinas_keluar',
    'status',
    'image_url',
    'waktu_mulai',
    'waktu_selesai',
    'jumlah_hari',
    'keterangan',
    'jenis_permohonan',
    'approved_by_id',
    'lokasi_dinas',
  ];

  public function pegawai()
  {
    return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
  }
}
