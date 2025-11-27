@extends('layouts.app')

@section('title', isset($mata_pelajaran) ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran')
@section('namePage', isset($mata_pelajaran) ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-6">
        <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-xl">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">
                {{ isset($mata_pelajaran) ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran' }}
            </h1>

            <form
                action="{{ isset($mata_pelajaran) ? route('mata_pelajaran.update', $mata_pelajaran->id) : route('mata_pelajaran.store') }}"
                method="POST" class="space-y-5">
                @csrf
                @if(isset($mata_pelajaran))
                    @method('PUT')
                @endif

                {{-- Nama Mata Pelajaran --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Nama Mata Pelajaran</label>
                    <input type="text" name="nama_pelajaran"
                        value="{{ old('nama_pelajaran', $mata_pelajaran->nama_pelajaran ?? '') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none"
                        placeholder="Masukkan nama mata pelajaran" required>
                    @error('nama_pelajaran')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kelas Terkait --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Kelas Terkait</label>
                    <select id="kelasSelect" name="kelas[]" multiple
                        class="w-full border-gray-300 rounded-xl p-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" @if(isset($mata_pelajaran_kelas) && in_array($k->id, $mata_pelajaran_kelas)) selected @endif>
                                {{ $k->tingkat_kelas }} {{ $k->jurusan->nama_jurusan ?? '' }} {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Guru Terkait --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Guru Terkait</label>
                    <select id="guruSelect" name="guru[]" multiple
                        class="w-full border-gray-300 rounded-xl p-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                        @foreach($guru as $g)
                            <option value="{{ $g->id }}" @if(isset($mata_pelajaran_guru) && in_array($g->id, $mata_pelajaran_guru)) selected @endif>
                                {{ $g->nama }} ({{ $g->nip ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                    @error('guru')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="flex justify-between items-center pt-4">
                    <a href="{{ route('mata_pelajaran.index') }}"
                        class="text-gray-600 hover:text-gray-800 font-medium transition">← Kembali</a>

                    <button type="submit"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-2 rounded-xl shadow transition">
                        {{ isset($mata_pelajaran) ? 'Perbarui' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('afterAppScripts')
    <!-- Tom Select CSS/JS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <style>
        /* Sedikit styling agar tag benar-benar bulat dan tombol x rapi */
        .ts-control .item {
            background-color: #6b21a8;
            /* purple-600 */
            color: white;
            border-radius: 9999px;
            /* rounded-full */
            padding: 0.25rem 0.75rem;
            margin-right: 0.25rem;
            margin-bottom: 0.25rem;
            display: inline-flex;
            align-items: center;
            font-size: 0.875rem;
            /* text-sm */
            line-height: 1;
        }

        .ts-control .item .remove {
            margin-left: 0.5rem;
            color: rgba(255, 255, 255, 0.95);
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .ts-control .item .remove:hover {
            color: rgba(255, 255, 255, 0.85);
        }

        /* make options look nicer */
        .ts-dropdown .option {
            padding: 0.5rem 0.75rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Konfigurasi umum TomSelect
            const tomSelectConfig = {
                plugins: ['remove_button'],
                persist: false,
                create: false,
                maxItems: null,
                hideSelected: true,
                valueField: 'value',
                labelField: 'text',
                searchField: ['text'],
                sortField: { field: 'text', direction: 'asc' },
                closeAfterSelect: false,
                render: {
                    option: function (data, escape) {
                        return '<div class="option">' + escape(data.text) + '</div>';
                    },
                    item: function (data, escape) {
                        return '<div>' + escape(data.text) + ' <a class="remove" tabindex="-1" title="Hapus">×</a></div>';
                    }
                }
            };

            // Inisialisasi TomSelect untuk Kelas
            new TomSelect("#kelasSelect", {
                ...tomSelectConfig,
                placeholder: 'Pilih satu atau lebih kelas...',
            });

            // Inisialisasi TomSelect untuk Guru
            new TomSelect("#guruSelect", {
                ...tomSelectConfig,
                placeholder: 'Pilih satu atau lebih guru...',
            });
        });
    </script>
@endsection