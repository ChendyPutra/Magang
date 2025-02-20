@extends('komentar.index')

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

@section('content')
<div id="rekap-hari" style="margin-top: 45px">
    <div class="max-w-4xl p-6 mx-auto my-10 bg-gray-200 rounded-lg shadow-lg">
        <h2 class="mb-6 text-xl font-semibold text-center">Komentar {{ ucfirst($type) }}</h2>

        <!-- Daftar Komentar -->
        <div class="space-y-6">
            @foreach($komentarData as $komentar)
                <div class="p-4 border-b-4 rounded-lg shadow-sm bg-gray-50">
                    <div class="text-lg font-semibold text-black">
                        {{ $komentar->nama ?: 'Anonymous' }}
                    </div>
                    <p class="mt-2 text-gray-700">{{ $komentar->komentar }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
