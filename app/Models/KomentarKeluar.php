<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KomentarKeluar extends Model
{
    use HasFactory;

    protected $table = 'komentar_keluar';
    protected $fillable = ['nama', 'komentar'];
}
