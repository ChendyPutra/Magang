<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use Illuminate\Http\Request;

class AnggaranController extends Controller
{
    public function index()
    {
        $anggaran = Anggaran::all();
        return view('anggaran.index', compact('anggaran'));
    }
    public function rapbdes(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));

        $anggaran = Anggaran::whereYear('tanggal', $tahun)->get();

        $totalRencana = $anggaran->sum('jumlah');
        $totalRealisasi = $anggaran->where('realisasi', true)->sum('jumlah');

        // Untuk form dropdown filter tahun (ambil tahun unik dari data)
        $daftarTahun = Anggaran::selectRaw('YEAR(tanggal) as tahun')->distinct()->pluck('tahun');

        return view('rapbdes', compact('anggaran', 'totalRencana', 'totalRealisasi', 'tahun', 'daftarTahun'));
    }



    public function create()
    {
        return view('anggaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rencana' => 'required|string',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        Anggaran::create($request->all());

        // Flash success message
        session()->flash('success', 'Anggaran successfully created!');

        return redirect()->route('anggaran.index');
    }

    public function edit($id)
    {
        $anggaran = Anggaran::findOrFail($id);
        return view('anggaran.edit', compact('anggaran'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rencana' => 'required|string',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $anggaran = Anggaran::findOrFail($id);
        $anggaran->update($request->all());

        // Flash success message
        session()->flash('success', 'Anggaran successfully updated!');

        return redirect()->route('anggaran.index');
    }

    public function destroy($id)
    {
        $anggaran = Anggaran::findOrFail($id);
        $anggaran->delete();

        // Flash success message
        session()->flash('success', 'Anggaran successfully deleted!');

        return redirect()->route('anggaran.index');
    }
    // Fungsi controller untuk kedua halaman (diagram dan RAPBDes)
    public function diagram()
    {
        // Ambil tahun yang unik dari tabel Anggaran
        $tahun = Anggaran::selectRaw('YEAR(tanggal) as tahun')
            ->groupBy('tahun')
            ->orderBy('tahun', 'DESC')
            ->pluck('tahun');

        // Hitung total 'rencana' dan 'realisasi' (jumlah nilai dari 'jumlah')
        $rencana = Anggaran::sum('jumlah');
        $realisasi = Anggaran::where('realisasi', 1)->sum('jumlah');

        return view('anggaran.diagram', compact('tahun', 'rencana', 'realisasi'));
    }



    public function updateRealisasi(Request $request, $id)
    {
        // Cari Anggaran berdasarkan ID dan perbarui status 'realisasi'
        $anggaran = Anggaran::findOrFail($id);
        $anggaran->realisasi = $request->has('realisasi') ? 1 : 0;
        $anggaran->save();

        return response()->json(['success' => true, 'message' => 'Status realisasi diperbarui!']);
    }

    public function filterStatistik($tahun)
    {
        // Filter data berdasarkan tahun yang dipilih
        $anggaran = Anggaran::whereYear('tanggal', $tahun)->get();

        // Jika tidak ada data untuk tahun yang dipilih, kembalikan nilai default
        if ($anggaran->isEmpty()) {
            return response()->json([
                'rencana' => 0,
                'realisasi' => 0
            ]);
        }

        // Hitung total 'rencana' dan 'realisasi'
        $rencana = $anggaran->sum('jumlah');
        $realisasi = $anggaran->where('realisasi', 1)->sum('jumlah');

        // Kembalikan data dalam format JSON
        return response()->json([
            'rencana' => $rencana,
            'realisasi' => $realisasi
        ]);
    }






}
