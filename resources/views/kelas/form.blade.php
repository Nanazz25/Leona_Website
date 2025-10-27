@extends('layouts.app')
@section('content')
    <div class="p-6 max-w-xl mx-auto">

        <h1 class="text-2xl font-semibold text-gray-800 mb-4">
            {{ isset($kelas) ? 'Edit Kelas' : 'Tambah Kelas' }}
        </h1>

        <form action="{{ isset($kelas) ? route('kelas.update', $kelas->id) : route('kelas.store') }}" method="POST"
            class="bg-white shadow-md rounded-lg p-6 space-y-4">
            @csrf
            @if(isset($kelas))
                @method('PUT')
            @endif

            {{-- Pilih Tingkat --}}
            <div>
                <label class="block text-gray-700 mb-1">Tingkat Kelas</label>
                <select name="tingkat_kelas" id="tingkat_kelas" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                    <option value="">-- Pilih Tingkat --</option>
                    @foreach(['10', '11', '12'] as $tingkat)
                        <option value="{{ $tingkat }}" {{ old('tingkat_kelas', $kelas->tingkat_kelas ?? '') == $tingkat ? 'selected' : '' }}>
                            {{ $tingkat }}
                        </option>
                    @endforeach
                </select>
                @error('tingkat_kelas')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Pilih Jurusan --}}
            <div>
                <label class="block text-gray-700 mb-1">Jurusan</label>
                <select name="id_jurusan" id="id_jurusan" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" data-nama="{{ $jurusan->nama_jurusan }}"
                            {{ old('id_jurusan', $kelas->id_jurusan ?? '') == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->nama_jurusan }}
                        </option>
                    @endforeach
                </select>
                @error('id_jurusan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Kelas Otomatis --}}
            <div>
                <label class="block text-gray-700 mb-1">Nama Kelas (otomatis)</label>
                <input type="text" name="nama_kelas" id="nama_kelas"
                    value="{{ old('nama_kelas', $kelas->nama_kelas ?? '') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 focus:outline-none"
                    readonly>
                <p class="text-sm text-gray-500 mt-1">Nama kelas akan dibuat otomatis saat disimpan.</p>
            </div>

            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('kelas.index') }}" class="text-gray-600 hover:text-gray-800 transition">← Kembali</a>

                <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow transition">
                    {{ isset($kelas) ? 'Perbarui' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>

    {{-- Script Preview Otomatis --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tingkatSelect = document.getElementById('tingkat_kelas');
        const jurusanSelect = document.getElementById('id_jurusan');
        const namaKelasInput = document.getElementById('nama_kelas');

        function updatePreview() {
            const tingkat = tingkatSelect.value;
            const jurusanId = jurusanSelect.value;
            const jurusanOption = jurusanSelect.options[jurusanSelect.selectedIndex];
            const jurusan = jurusanOption ? jurusanOption.getAttribute('data-nama') : '';

            if (tingkat && jurusanId) {
                fetch(`/kelas/count?tingkat=${tingkat}&jurusan=${jurusanId}`)
                    .then(res => res.json())
                    .then(data => {
                        namaKelasInput.value = `${tingkat} ${jurusan} ${data.count + 1}`;
                    });
            } else {
                namaKelasInput.value = '';
            }
        }

        tingkatSelect.addEventListener('change', updatePreview);
        jurusanSelect.addEventListener('change', updatePreview);
    });
</script>

@endsection
