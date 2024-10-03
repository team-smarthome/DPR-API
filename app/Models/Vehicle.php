<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use SoftDeletes, HasUuids;
    protected $table = 'vehicle';

    protected $fillable = [
        'id',
        'pegawai_id',
        'pengunjung_id',
        'plat_nomor',
        'grup_vehicle_pegawai_id',
        'image_url',    
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

    public function pengunjung()
    {
        return $this->belongsTo(Pengunjung::class, 'pengunjung_id', 'id');
    }

    public function grupVehiclePegawai()
    {
        return $this->belongsTo(GrupVehiclePegawai::class, 'grup_vehicle_pegawai_id', 'id');
    }
}
