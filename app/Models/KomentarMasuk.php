<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KomentarMasuk extends Model
{
    use HasFactory;

    protected $table = 'komentar_masuk';
    protected $fillable = ['nama', 'komentar'];
}
