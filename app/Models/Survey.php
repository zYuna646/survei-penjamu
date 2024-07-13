<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'jenis_id',
        'target_id',
        'isAktif'
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

   

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($survey) {
            $survey->code = self::generateUniqueCode();
        });
    }

    private static function generateUniqueCode()
    {
        do {
            $code = Str::upper(Str::random(10)); // Generate a random 10-character string
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
