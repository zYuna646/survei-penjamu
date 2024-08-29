<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'fakutlas_id'
    ];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }
}
