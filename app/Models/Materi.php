<?php

namespace App\Models;

use App\Models\Kursus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materi extends Model
{
    use SoftDeletes;
    protected $table = 'materi';
    protected $fillable = [
        'judul',
        'deskripsi' , 
        'kursus_id' , 
    ];

    protected function kursus(): BelongsTo {
        return $this->belongsTo(Kursus::class , 'kursus_id' , 'id');
    }
}
