<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DeviceZone extends Model
{
    use SoftDeletes, HasUuids;

    protected $guarded = [];
    protected $table = 'zona_device';
    protected $keyType = 'uuid';
    public $incrementing = false;
    public $timestamps = true;

    public function Device(): HasOne
    {
        return $this->hasOne(Device::class, "id", "device_id");
    }

    public function Zona(): HasOne
    {
        return $this->hasOne(Zona::class, "id", "zona_id");
    }
}
