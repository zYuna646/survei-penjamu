<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'aspek_id'
    ];

    public function aspek()
    {
        return $this->belongsTo(Aspek::class);
    }
}
