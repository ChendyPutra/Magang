<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class anggaran extends Model
{
    use HasFactory;

    protected $table = 'anggaran';

    protected $fillable = ['rencana', 'jumlah', 'tanggal', 'keterangan', 'realisasi'];

}
