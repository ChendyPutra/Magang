@extends('pengelolaan.index')

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

@section('content')
    @if(session('success'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div id="anggaran-table" style="display: block;">
        <h2 class="text-xl font-bold text-center mb-4">Tabel Anggaran</h2>
        <button onclick="toggleModal('modal-tambah-anggaran')" class="px-4 py-2 text-white bg-purple-700 rounded">
            Tambah Anggaran
        </button>

        <!-- Modal Tambah anggaran -->
        <div id="modal-tambah-anggaran" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-800 bg-opacity-50">
            <div class="flex items-center justify-center min-h-screen">
                <div class="p-6 bg-white rounded-lg shadow-lg w-96">
                    <h2 class="mb-4 text-lg font-bold text-center">Tambah Anggaran</h2>
                    <form action="{{ route('anggaran.store') }}" method="POST">
                        @csrf
                        <label class="block mb-2" for="rencana">Rencana</label>
                        <input type="string" class="w-full p-2 mb-4 border rounded" id="rencana" name="rencana" placeholder="Masukkan rencana">


                        <label class="block mb-2" for="jumlah">Jumlah</label>
                        <input type="number" class="w-full p-2 mb-4 border rounded" id="jumlah" name="jumlah" placeholder="Masukkan jumlah">

                        <label class="block mb-2" for="tanggal">Tanggal</label>
                        <input type="date" class="w-full p-2 mb-4 border rounded" id="tanggal" name="tanggal">

                        <label class="block mb-2" for="keterangan">Keterangan</label>
                        <input type="text" class="w-full p-2 mb-4 border rounded" id="keterangan" name="keterangan">

                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('anggaran.index') }}" class="px-4 py-2 text-white bg-gray-400 rounded">Batal</a>
                            <button type="submit" class="px-4 py-2 text-white bg-purple-700 rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Gaya tabel sesuai dengan contoh Anda -->
        <table class="w-full mt-6 bg-white shadow-lg rounded-lg">
            <thead>
                <tr class="bg-purple-700 text-white">
                    <th class="border-r p-2">No</th>
                    <th class="border-r p-2">Rencana</th>
                    <th class="border-r p-2">Jumlah</th>
                    <th class="border-r p-2">Tanggal</th>
                    <th class="border-r p-2">Keterangan</th>
                    <th class="border-r p-2">Realisasi</th>
                    <th class="border-r p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($anggaran as $index => $item)
                                <tr class="border-t">
                                    <td class="p-2">{{ $index + 1 }}</td>
                                    <td class="p-2">{{ $item->rencana }}</td>
                                    <td class="p-2">Rp {{ number_format($item->jumlah, 2, ',', '.') }}</td>
                                    <td class="p-2">{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
                                    <td class="p-2">{{ $item->keterangan }}</td>
                                    <td class="p-2">
                                        <input type="checkbox" class="realisasi-checkbox" data-id="{{ $item->id }}" {{ $item->realisasi ? 'checked' : '' }}>
                                    </td>
                                    <td class="p-2">
                    <!-- Tombol Edit -->
                    <button onclick="toggleModal('modal-edit-anggaran-{{ $item->id }}')" class="px-4 py-2 text-white bg-blue-500 rounded">
                        Edit
                    </button>

                    <!-- Modal Edit -->
                    <div id="modal-edit-anggaran-{{ $item->id }}"
                        class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-800 bg-opacity-50">
                        <div class="flex items-center justify-center min-h-screen">
                            <div class="p-6 bg-white rounded-lg shadow-lg w-96">
                                <h2 class="mb-4 text-lg font-bold text-center">Edit Anggaran</h2>
                                <form action="{{ route('anggaran.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                        
                                    <!-- Dropdown Sumber Dana -->
                                    <label class="block mb-2" for="rencana">Rencana</label>
                                    <input type="string" class="w-full p-2 mb-4 border rounded" id="rencana" name="rencana" 
                                    value="{{ old('rencana', $item->jumlah) }}" placeholder="Masukkan Rencana" required>
                        
                                    <!-- Input Jumlah -->
                                    <label class="block mb-2" for="jumlah">Jumlah</label>
                                    <input type="number" class="w-full p-2 mb-4 border rounded" id="jumlah" name="jumlah" 
                                           value="{{ old('jumlah', $item->jumlah) }}" placeholder="Masukkan jumlah" required>
                        
                                    <!-- Input Tanggal -->
                                    <label class="block mb-2" for="tanggal">Tanggal</label>
                                    <input type="date" class="w-full p-2 mb-4 border rounded" id="tanggal" name="tanggal" 
                                           value="{{ old('tanggal', $item->tanggal) }}" required>
                        
                                    <!-- Input Keterangan -->
                                    <label class="block mb-2" for="keterangan">Keterangan</label>
                                    <input type="string" class="w-full p-2 mb-4 border rounded" id="keterangan" name="keterangan" 
                                    value="{{ old('keterangan', $item->keterangan) }}" required>
                                    <!-- Tombol Aksi -->
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('anggaran.index') }}" class="px-4 py-2 text-white bg-gray-400 rounded">Batal</a>
                                        <button type="submit" class="px-4 py-2 text-white bg-purple-700 rounded">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Tombol Hapus dengan Konfirmasi -->
                                        <form action="{{ route('anggaran.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
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
        document.querySelectorAll('.realisasi-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                let anggaranId = this.dataset.id;
                let isChecked = this.checked ? 1 : 0;

                fetch(`/anggaran/update-realisasi/${anggaranId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ realisasi: isChecked })
                })
                .then(response => response.json())
                .then(data => alert(data.message))
                .catch(error => console.error('Error:', error));
            });
        });

        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus data ini?');
        }
        function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
         }
    </script>
@endsection
