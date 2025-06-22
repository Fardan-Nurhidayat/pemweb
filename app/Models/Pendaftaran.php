<?php

namespace App\Models;

use App\Models\Kursus;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran' ;
    protected $fillable = [
        'kursus_id' , 
        'peserta_id' , 
        'status',
    ];

    protected function kursus():BelongsTo {
        return $this->belongsTo(Kursus::class , 'kursus_id' , 'id');
    }

    protected function user():BelongsTo {
        return $this->belongsTo(User::class , 'peserta_id' , 'id');
    }
}
