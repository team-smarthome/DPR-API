<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id');
    }

    public function palmData()
    {
        return $this->hasOne(PalmData::class, 'palm_data_id', 'id');
    }

    public function facialData()
    {
        return $this->hasOne(FacialData::class, 'face_id', 'id');
    }

    public function grupPegawai()
    {
        return $this->belongsTo(GrupPegawai::class, 'grup_pegawai_id', 'id');
    }

}
