<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacialData extends Model
{
  use SoftDeletes, HasUuids;

  protected $table = 'facial_data';

  protected $fillable = [
    'id',
    'face_template',
    'created_at',
    'updated_at',
    'deleted_at',
  ];

  public $incrementing = false;
  protected $keyType = 'uuid';
  public $timestamps = true;

  public function pegawai()
  {
    return $this->belongsTo(Pegawai::class, 'face_id', 'id');
  }

  public function pengunjung()
  {
    return $this->belongsTo(Pengunjung::class, 'face_id', 'id');
  }
}
