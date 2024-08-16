<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'indikator_id',
        'fakultas_id',
        'prodi_id',
        'temuan',
        'solusi'
    ];

    public function indikator()
    {
        return $this->belongsTo(Indikator::class);
    }

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
    
}
