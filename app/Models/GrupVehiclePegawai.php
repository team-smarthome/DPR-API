<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GrupVehiclePegawai extends Model
{

    use SoftDeletes, HasUuids;
    protected $table = 'grup_vehicle_pegawai';

    protected $fillable = [
        'id',
        'vehicle_id',
        'nama_grup_vehicle_pegawai',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $incrementing = false;
    protected $keyType = 'uuid';
    public $timestamps = true;

    public function vehicle()
    {
        return $this->hasMany(Vehicle::class, 'grup_vehicle_pegawai_id', 'id');
    }

}
