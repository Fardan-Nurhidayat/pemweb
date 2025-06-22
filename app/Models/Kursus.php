<?php

namespace App\Models;

use App\Models\User;
use App\Models\Materi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kursus extends Model
{
    protected $table = 'kursuses';

    protected $fillable = [
        'nama',
        'durasi',
        'biaya',
        'instruktur_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class , 'instruktur_id' , 'id');
    }
}
