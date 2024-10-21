<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GrupPegawai extends Model
{

    use SoftDeletes, HasUuids;
    protected $table = 'grup_pegawai';

    protected $fillable = [
        'id',
        'ketua_grup',
        'nama_grup_pegawai',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $incrementing = false;
    protected $keyType = 'uuid';
    public $timestamps = true;

    public function pegawai()
    {
       return $this->hasMany(Pegawai::class, 'grup_pegawai_id', 'id');
    }

    public function ketuaGrup()
    {
        return $this->belongsTo(Pegawai::class, 'ketua_grup');
    }

}
