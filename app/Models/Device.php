<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
  use SoftDeletes, HasUuids;

  protected $guarded = [];
  protected $table = 'device';
  protected $keyType = 'uuid';
  public $incrementing = false;
  public $timestamps = true;


  public function DeviceZone(): HasMany
  {
    return $this->hasMany(DeviceZone::class, "device_id", "id");
  }
  public function DeviceType(): BelongsTo
  {
    return $this->belongsTo(DeviceType::class, "dtype", "id");
  }
}
