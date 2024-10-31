<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WfhPegawai extends Model
{

  use SoftDeletes, HasUuids;
  protected $table = 'wfh_pegawai';

  protected $fillable = [
    'id',
    'pegawai_id',
    'nama_wfh_pegawai',
    'waktu_mulai',
    'waktu_selesai',
    'jumlah_hari',
    'image_url',
    'status',
    'approved_by_id',
    'keterangan',
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
