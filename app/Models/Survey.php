<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'jenis_id',
        'target_id',
    ];

    public function target()
    {
        return $this->belongsTo(Target::class);
    }

    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }

    public function aspek()
    {
        return $this->hasMany(Aspek::class);
    }

    public function indikator()
    {
        return $this->hasMany(Indikator::class);
    }
}
