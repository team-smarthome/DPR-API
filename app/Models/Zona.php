<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zona extends Model
{
  use SoftDeletes, HasUuids;
  protected $table = 'zona';
  protected $keyType = 'uuid';
  public $incrementing = false;
  public $timestamps = true;

//   protected $fillable = [
//     'nama_zona',
//     'jenis_zona',
//     'lokasi_id',
//     'panjang',
//     'lebar',
//     'posisi_X',
//     'posisi_Y',
//     'parent_id',
//     'jenis_restriksi',
//   ];

    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(Zona::class, 'id', 'parent_id');
    }

    public function recursiveParents()
    {
        return $this->parent()->with('recursiveParents');
    }


    public function DeviceZone(): HasMany
    {
        return $this->hasMany(DeviceZone::class, 'zona_id', 'id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id', 'id');
    }
}
