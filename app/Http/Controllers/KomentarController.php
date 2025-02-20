<?php

namespace App\Http\Controllers;
use App\Models\KomentarMasuk;
use App\Models\KomentarKeluar;
use App\Models\KomentarRapbdess;
use Illuminate\Support\Facades\DB;



use Illuminate\Http\Request;

class KomentarController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan tipe komentar dari URL atau query
        $type = $request->query('type', 'masuk'); // Default 'masuk'
    
        // Mengambil data komentar sesuai tipe
        switch ($type) {
            case 'masuk':
                $komentarData = KomentarMasuk::all();
                break;
            case 'keluar':
                $komentarData = KomentarKeluar::all();
                break;
            case 'rapbdess':
                $komentarData = KomentarRapbdess::all();
                break;
            default:
                $komentarData = collect([]); // Kosongkan jika tidak sesuai
                break;
        }
    
        return view('komentar.index', compact('komentarData', 'type'));
    }
    

    public function masuk()
{
    $type = 'Pemasukan';  // Menetapkan nilai 'masuk' untuk type
    $komentarData = KomentarMasuk::all();
    return view('komentar.masuk', compact('komentarData', 'type'));
}

public function keluar()
{
    $type = 'Pengeluaran';  // Menetapkan nilai 'keluar' untuk type
    $komentarData = KomentarKeluar::all();
    return view('komentar.keluar', compact('komentarData', 'type'));
}

public function rapbdess()
{
    $type = 'RAPBDes';  // Menetapkan nilai 'rapbdess' untuk type
    $komentarData = KomentarRapbdess::all();
    return view('komentar.rapbdess', compact('komentarData', 'type'));
}


public function show($type)
{
    // Tentukan tabel berdasarkan tipe komentar
    $tableMap = [
        'masuk' => 'komentar_masuk',
        'keluar' => 'komentar_keluar',
        'rapbdess' => 'komentar_rapbdess',
    ];

    // Cek apakah tipe valid
    if (!array_key_exists($type, $tableMap)) {
        abort(404, 'Invalid komentar type');
    }

    // Ambil data komentar dari tabel yang sesuai
    $komentarData = DB::table($tableMap[$type])->get();

    // Kirim data ke view
    return view('komentar.index', compact('komentarData', 'type'));
}




public function store(Request $request, $type)
{
    // Validasi input
    $request->validate([
        'nama' => 'nullable|string|max:25',
        'komentar' => 'required|string|max:100',
    ]);

    // Tentukan tabel berdasarkan tipe komentar
    $tableMap = [
        'pemasukan' => 'komentar_masuk',
        'pengeluaran' => 'komentar_keluar',
        'rapbdess' => 'komentar_rapbdess',
    ];

    if (!array_key_exists($type, $tableMap)) {
        abort(404, 'Invalid komentar type');
    }

    // Masukkan data ke tabel yang sesuai menggunakan DB facade
    DB::table($tableMap[$type])->insert([
        'nama' => $request->input('anonymous') ? 'Anonymous' : $request->input('nama'),
        'komentar' => $request->input('komentar'),
    ]);

    // Kirim notifikasi ke halaman yang sama
    return back()->with('success', 'Komentar telah terkirim.');

}



}
