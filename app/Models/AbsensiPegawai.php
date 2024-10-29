<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsensiPegawai extends Model
{

  use SoftDeletes, HasUuids;
  protected $table = 'absensi_pegawai';

  protected $fillable = [
    'id',
    'pegawai_id',
    'nama_absensi_pegawai',
    'status',
    'jenis',
    'waktu_mulai',
    'waktu_selesai',
    'approved_by_id',
    'keterangan',
    'image_url',
    'created_at',
    'updated_at',
    'deleted_at',
  ];

  public $incrementing = false;
  protected $keyType = 'uuid';
  public $timestamps = true;

  public function pegawai()
  {
    return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
  }
}
