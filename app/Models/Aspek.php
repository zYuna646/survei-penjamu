<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspek extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'survey_id'
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function indicator()
    {
        return $this->hasMany(Indikator::class);
    }
}
