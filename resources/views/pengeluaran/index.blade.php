@extends('dashboard')

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

@section('content')
        @if(session('success'))
            <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
                {{ session('success') }}
            </div>
        @endif


            <div id="pengeluaran-table" style="display: block;">
                <h2 class="text-xl font-bold text-center mb-4">Tabel Pengeluaran</h2>
                <!-- Tombol Tambah -->
                <button onclick="toggleModal('modal-tambah-pengeluaran')" class="px-4 py-2 text-white bg-purple-700 rounded">
                    Tambah Pengeluaran
                </button>
        
                <!-- Modal Tambah pengeluaran -->
                <div id="modal-tambah-pengeluaran" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-800 bg-opacity-50">
                    <div class="flex items-center justify-center min-h-screen">
                        <div class="p-6 bg-white rounded-lg shadow-lg w-96">
                            <h2 class="mb-4 text-lg font-bold text-center">Tambah Pengeluaran</h2>
                            <form action="{{ route('pengeluaran.store') }}" method="POST">
                                @csrf
                                <label class="block mb-2" for="sumber_dana">Sumber Dana</label>
                                <select class="w-full p-2 mb-4 border rounded" name="sumber_dana" id="sumber_dana" required>
                                    <option>Pilih Sumber Dana</option>
                                    <option value="APBN">APBN</option>
                                    <option value="APBD">APBD</option>
                                    <option value="Dana Desa">Dana Desa</option>
                                    <option value="Swadaya">Swadaya</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
        
                                <label class="block mb-2" for="jumlah">Jumlah</label>
                                <input type="number" class="w-full p-2 mb-4 border rounded" id="jumlah" name="jumlah" placeholder="Masukkan jumlah" required>
        
                                <label class="block mb-2" for="tanggal">Tanggal</label>
                                <input type="date" class="w-full p-2 mb-4 border rounded" id="tanggal" name="tanggal" required>
        
                                <label class="block mb-2" for="keterangan">Keterangan</label>
                                <input type="text" class="w-full p-2 mb-4 border rounded" id="keterangan" name="keterangan" placeholder="Masukkan keterangan">
        
                                <div class="flex justify-end space-x-2">
                                    <button type="button" onclick="toggleModal('modal-tambah-pengeluaran')" class="px-4 py-2 text-white bg-gray-400 rounded">Batal</button>
                                    <button type="submit" class="px-4 py-2 text-white bg-purple-700 rounded">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <table class="w-full mt-6 bg-white shadow-lg rounded-lg">
                    <thead>
                        <tr class="bg-purple-700 text-white">
                            <th class="border-r p-2">No</th>
                            <th class="border-r p-2">Sumber Dana</th>
                            <th class="border-r p-2">Jumlah</th>
                            <th class="border-r p-2">Tanggal</th>
                            <th class="border-r p-2">Keterangan</th>
                            <th class="border-r p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengeluaran as $index => $item)
                                                    <tr class="border-t">
                                                        <td class="p-2">{{ $index + 1 }}</td>
                                                        <td class="p-2">{{ $item->sumber_dana }}</td>
                                                        <td class="p-2">{{ $item->jumlah }}</td>
                                                        <td class="p-2">{{ $item->tanggal }}</td>
                                                        <td class="p-2">{{ $item->keterangan }}</td>
                                                        <td class="p-2">
                            <!-- Tombol Edit -->
                            <button onclick="toggleModal('modal-edit-pengeluaran-{{ $item->id }}')" class="px-4 py-2 text-white bg-blue-500 rounded">
                                Edit
                            </button>

                            <!-- Modal Edit -->
                            <div id="modal-edit-pengeluaran-{{ $item->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-800 bg-opacity-50">
                                <div class="flex items-center justify-center min-h-screen">
                                    <div class="p-6 bg-white rounded-lg shadow-lg w-96">
                                        <h2 class="mb-4 text-lg font-bold text-center">Edit pengeluaran</h2>
                                        <form action="{{ route('pengeluaran.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <label class="block mb-2" for="sumber_dana">Sumber Dana</label>
                                            <select class="w-full p-2 mb-4 border rounded" id="sumber_dana" name="sumber_dana" required>
                                                <option value="">Pilih Sumber Dana</option>
                                                <option value="APBN" {{ old('sumber_dana', $item->sumber_dana) == 'APBN' ? 'selected' : '' }}>APBN</option>
                                                <option value="APBD" {{ old('sumber_dana', $item->sumber_dana) == 'APBD' ? 'selected' : '' }}>APBD</option>
                                                <option value="Dana Desa" {{ old('sumber_dana', $item->sumber_dana) == 'Dana Desa' ? 'selected' : '' }}>Dana Desa</option>
                                                <option value="Swadaya" {{ old('sumber_dana', $item->sumber_dana) == 'Swadaya' ? 'selected' : '' }}>Swadaya</option>
                                                <option value="Lainnya" {{ old('sumber_dana', $item->sumber_dana) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                            </select>

                                            <label class="block mb-2" for="jumlah">Jumlah</label>
                                            <input type="number" class="w-full p-2 mb-4 border rounded" id="jumlah" name="jumlah" value="{{ old('jumlah', $item->jumlah) }}" required>

                                            <label class="block mb-2" for="tanggal">Tanggal</label>
                                            <input type="date" class="w-full p-2 mb-4 border rounded" id="tanggal" name="tanggal" value="{{ old('tanggal', $item->tanggal) }}" required>

                                            <label class="block mb-2" for="keterangan">Keterangan</label>
                                            <input type="text" class="w-full p-2 mb-4 border rounded" id="keterangan" name="keterangan" value="{{ old('keterangan', $item->keterangan) }}" required>

                                            <div class="flex justify-end space-x-2">
                                                <button type="button" onclick="toggleModal('modal-edit-pengeluaran-{{ $item->id }}')" class="px-4 py-2 text-white bg-gray-400 rounded">Batal</button>
                                                <button type="submit" class="px-4 py-2 text-white bg-purple-700 rounded">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Hapus dengan Konfirmasi -->
                                                            <form action="{{ route('pengeluaran.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
@endsection

@section('scripts')
    <script>
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus data ini?');
        }
        function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }
    </script>
@endsection
