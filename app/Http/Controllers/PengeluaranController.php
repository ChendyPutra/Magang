<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index()
    {
        $pengeluaran = Pengeluaran::all();
        return view('pengeluaran.index', compact('pengeluaran'));
    }
    public function view(Request $request)
{
    // Ambil bulan dan tahun dari query string, default ke sekarang
    $bulan = $request->input('bulan', now()->format('m'));
    $tahun = $request->input('tahun', now()->format('Y'));

    // Ambil data pengeluaran berdasarkan bulan dan tahun
    $pengeluaran = Pengeluaran::whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->get();

    // Daftar kategori tetap
    $kategori = ['APBN', 'APBD', 'Dana Desa', 'Swadaya'];

    // Siapkan data chart berdasarkan kategori
    $chartData = [];
    foreach ($kategori as $k) {
        $chartData[$k] = $pengeluaran->where('sumber_dana', $k)->sum('jumlah');
    }

    return view('pengeluaran_view', compact('pengeluaran', 'chartData', 'bulan', 'tahun'));
}


    public function create()
    {
        return view('pengeluaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
           'sumber_dana' => 'required|in:APBN,APBD,Dana Desa,Swadaya,Lainnya',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            
        ]);

        Pengeluaran::create($request->all());
        return redirect()->route('pengeluaran.index');
    }

    public function edit($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        return view('pengeluaran.edit', compact('pengeluaran'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'sumber_dana' => 'required|in:APBN,APBD,Dana Desa,Swadaya,Lainnya',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);
    
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->update($validated);
    
        return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil diperbarui.');
    }
    

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();
        return redirect()->route('pengeluaran.index');
    }
}
