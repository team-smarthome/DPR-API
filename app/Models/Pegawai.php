<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Pegawai extends Model
{
  use SoftDeletes, HasUuids;
  protected $table = 'pegawai';

  protected $fillable = [
    'id',
    'nip',
    'nama_pegawai',
    'jenis_kelamin',
    'is_active',
    'jabatan_id',
    'email',
    'phone',
    'palm_data_id',
    'face_id',
    'grup_pegawai_id',
    'created_at',
    'updated_at',
    'deleted_at',
  ];

  public $incrementing = false;
  protected $keyType = 'uuid';
  public $timestamps = true;


  public function user()
  {
    return $this->hasOne(User::class, 'pegawai_id', 'id');
  }
  public function palmData()
  {
    return $this->belongsTo(PalmData::class, 'palm_data_id', 'id');
  }

  public function jabatan()
  {
    return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id');
  }

  public function facialData()
  {
    return $this->belongsTo(FacialData::class, 'face_id', 'id');
  }

  public function grupPegawai()
  {
    return $this->belongsTo(GrupPegawai::class, 'grup_pegawai_id', 'id');
  }

  public function wfhPegawai()
  {
    return $this->hasMany(WfhPegawai::class, 'pegawai_id', 'id');
  }

  public function absensiPegawai()
  {
    return $this->hasMany(AbsensiPegawai::class, 'pegawai_id', 'id');
  }

  public function vehicle()
  {
    return $this->hasMany(Vehicle::class, 'pegawai_id', 'id');
  }
}
