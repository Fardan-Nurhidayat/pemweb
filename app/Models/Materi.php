<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Materi extends Model
{
    protected $table = 'materis';
    protected $fillable = [
        'judul',
        'deskripsi',
        'kursus_id'
    ];

    protected function kursus() : HasOne{
        return $this->hasOne(Kursus::class , 'kursus_id' , 'id');
    }

}
