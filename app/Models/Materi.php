<?php

namespace App\Models;

use App\Models\Kursus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materi extends Model
{
    protected $table = 'materi';
    protected $fillable = [
        'judul',
        'deskripsi' , 
        'kursus_id' , 
    ];

    public function kursus(): BelongsTo {
        return $this->belongsTo(Kursus::class , 'kursus_id');
    }
}
