<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Instansi extends Model
{
  use SoftDeletes, HasUuids;
  protected $table = 'instansi';
  protected $keyType = 'uuid';
  public $incrementing = false;
  public $timestamps = true;

  protected $fillable = [
    'nama_instansi'
  ];

  public function Instansi(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'instansi_id', 'id');
    }
}
