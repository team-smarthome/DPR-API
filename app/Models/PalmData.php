<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

class PalmData extends Model
{
    use SoftDeletes, HasUuids;

    protected $table = 'palm_data';

    protected $fillable = [
        'id',
        'vein_pattern',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $incrementing = false;
    protected $keyType = 'uuid';
    public $timestamps = true;

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'palm_data_id', 'id');
    }
}
