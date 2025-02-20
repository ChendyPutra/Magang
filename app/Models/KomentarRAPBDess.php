<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KomentarRAPBDess extends Model
{
    use HasFactory;

    protected $table = 'komentar_rapbdess';
    protected $fillable = ['nama', 'komentar'];
}
