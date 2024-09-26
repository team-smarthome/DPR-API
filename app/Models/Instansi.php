<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
