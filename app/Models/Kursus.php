<?php

namespace App\Models;

use App\Models\User;
use App\Models\Materi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kursus extends Model
{
    use HasFactory;

    protected $table = "kursus";
    protected $fillable = [
        'nama_kursus', 
        'durasi', 
        'instruktur_id' ,
        'biaya', 
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instruktur_id' , 'id');
    }

    protected function materi() : HasMany {
        return $this->hasMany(Materi::class);
    }
}
