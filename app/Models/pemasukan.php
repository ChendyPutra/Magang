<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;

    protected $table = 'pemasukan';

    protected $fillable = ['sumber_dana', 'jumlah', 'tanggal', 'keterangan'];

    // Enum values for sumber_dana
    public static function sumberDanaOptions()
    {
        return ['APBN', 'APBD', 'Dana Desa', 'Swadaya', 'Lainnya'];
    }
}

