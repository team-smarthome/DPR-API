<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lokasi extends Model
{
  use SoftDeletes, HasUuids;
  protected $table = 'lokasi';
  protected $keyType = 'uuid';
  public $incrementing = false;
  public $timestamps = true;

  protected $fillable = [
    'nama_lokasi',
    'latitude',
    'longitude',
  ];
  public function zona()
  {
    return $this->hasMany(Zona::class, 'lokasi_id', 'id'); // Satu lokasi memiliki banyak zona
  }
}
