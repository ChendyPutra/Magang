<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemasukanController extends Controller
{
    public function index()
    {
        $pemasukan = Pemasukan::all();
        return view('pemasukan.index', compact('pemasukan'));
    }
   
    public function showForUser(Request $request)
{
    $bulan = $request->input('bulan', date('m')); // default: bulan sekarang
    $tahun = $request->input('tahun', date('Y')); // default: tahun sekarang

    // Ambil data pemasukan sesuai bulan dan tahun
    $pemasukan = Pemasukan::whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->get();

    // Kategori tetap
    $kategoriTetap = ['APBN', 'APBD', 'Dana Desa', 'Swadaya'];

    // Hitung total per kategori untuk chart
    $chartData = [];
    foreach ($kategoriTetap as $kategori) {
        $chartData[$kategori] = $pemasukan->where('sumber_dana', $kategori)->sum('jumlah');
    }

    return view('welcome', compact('pemasukan', 'bulan', 'tahun', 'chartData'));
}




    public function create()
    {
        return view('pemasukan.create');
    }

    // Method to store the data from the form
    public function store(Request $request)
{
    $request->validate([
        'sumber_dana' => 'required|in:APBN,APBD,Dana Desa,Swadaya,Lainnya',
        'jumlah' => 'required|numeric|min:0',
        'tanggal' => 'required|date',
        'keterangan' => 'nullable|string',
    ]);

    Pemasukan::create($request->all());

    return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil ditambahkan.');
}


    public function edit($id)
    {
        $pemasukan = Pemasukan::findOrFail($id);
        return view('pemasukan.edit', compact('pemasukan'));
    }

    public function update(Request $request, $id)
{
    // Validasi data
    $validated = $request->validate([
        'sumber_dana' => 'required|string|max:255',
        'jumlah' => 'required|numeric',
        'tanggal' => 'required|date',
        'keterangan' => 'nullable|string',
    ]);

    // Cari data berdasarkan ID dan update
    $pemasukan = Pemasukan::findOrFail($id);
    $pemasukan->update($validated);

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil diperbarui.');
}

public function destroy($id)
{
    $pemasukan = Pemasukan::findOrFail($id);
    $pemasukan->delete();
    return redirect()->route('pemasukan.index')->with('success', 'Data berhasil dihapus.');
}
public function getPieChartData()
{
    $data = DB::table('pemasukan')
        ->select('kategori', DB::raw('SUM(jumlah) as total'))
        ->groupBy('kategori')
        ->pluck('total', 'kategori');

    // Pastikan 4 kategori tetap ada (jika data kosong, isi dengan 0)
    $chartData = [
        'APBN' => $data['APBN'] ?? 0,
        'APBD' => $data['APBD'] ?? 0,
        'Dana Desa' => $data['Dana Desa'] ?? 0,
        'Swadaya' => $data['Swadaya'] ?? 0,
    ];

    return response()->json($chartData);
}


}
