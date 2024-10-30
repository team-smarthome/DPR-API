<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LemburPegawai extends Model
{
  use SoftDeletes, HasUuids;
  protected $table = 'lembur_pegawai';

  protected $fillable = [
    'pegawai_id',
    'nama_absensi_pegawai',
    'status',
    'jenis',
    'image_url',
    'status',
    'waktu_masuk',
    'waktu_keluar',
    'keterangan',
    'approved_by_id'
  ];

  public function pegawai()
  {
    return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
  }
}
