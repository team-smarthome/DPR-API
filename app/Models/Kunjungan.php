<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kunjungan extends Model
{
  use SoftDeletes, HasUuids;

  protected $guarded = [];
  protected $table = 'kunjungan';
  protected $keyType = 'uuid';
  public $incrementing = false;
  public $timestamps = true;

  protected $casts = [
    'waktu_mulai' => 'datetime',
    'waktu_berakhir' => 'datetime',
  ];
  public function pengunjung()
  {
    return $this->belongsToMany(Pengunjung::class, 'pivot_kunjungan', 'kunjungan_id', 'pengunjung_id');
  }

  public function pegawai()
  {
    return $this->belongsTo(Pegawai::class, 'approved_by_id', 'id');
  }
}
