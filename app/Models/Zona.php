<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zona extends Model
{
  use SoftDeletes, HasUuids;
  protected $table = 'zona';
  protected $keyType = 'uuid';
  public $incrementing = false;
  public $timestamps = true;

  protected $fillable = [
    'nama_zona',
    'jenis_zona',
    'lokasi_id',
    'panjang',
    'lebar',
    'posisi_X',
    'posisi_Y',
    'parent_id',
    'jenis_restriksi',
  ];

  public function parent()
  {
    return $this->belongsTo(Zona::class, 'parent_id');
  }

  // Relasi rekursif untuk children
  public function children()
  {
    return $this->hasMany(Zona::class, 'parent_id');
  }

  public function DeviceZone(): HasMany
  {
    return $this->hasMany(DeviceZone::class, 'zona_id', 'id');
  }

  // public function devices()
  // {
  //     return $this->hasMany(Device::class, 'zona_id', 'zona_id');
  // }

  public function lokasi()
  {
    return $this->belongsTo(Lokasi::class, 'lokasi_id', 'id');
  }
}
