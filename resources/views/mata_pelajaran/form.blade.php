@extends('layouts.app')

@section('title', isset($mata_pelajaran) ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran')
@section('namePage', isset($mata_pelajaran) ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="flex justify-center">
            <div class="w-full md:w-2/3">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <div class="mb-6">
                             <h4 class="text-xl font-bold text-gray-800">{{ isset($mata_pelajaran) ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran' }}</h4>
                        </div>

                        <form
                            action="{{ isset($mata_pelajaran) ? route('mata_pelajaran.update', $mata_pelajaran->id) : route('mata_pelajaran.store') }}"
                            method="POST">
                            @csrf
                            @if(isset($mata_pelajaran))
                                @method('PUT')
                            @endif

                            {{-- Nama Mata Pelajaran --}}
                            <div class="mb-6">
                                <label class="block font-medium text-sm text-gray-700 mb-2">Nama Mata Pelajaran</label>
                                <input type="text" name="nama_pelajaran"
                                    value="{{ old('nama_pelajaran', $mata_pelajaran->nama_pelajaran ?? '') }}"
                                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full"
                                    placeholder="Masukkan nama mata pelajaran" required>
                                @error('nama_pelajaran')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Kelas Terkait --}}
                            <div class="mb-6">
                                <label class="block font-medium text-sm text-gray-700 mb-2">Kelas Terkait</label>
                                <select id="kelasSelect" name="kelas[]" multiple
                                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full">
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" @if(isset($mata_pelajaran_kelas) && in_array($k->id, $mata_pelajaran_kelas)) selected @endif>
                                            {{ $k->tingkat_kelas }} {{ $k->jurusan->nama_jurusan ?? '' }} {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kelas')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Guru Terkait --}}
                            <div class="mb-6">
                                <label class="block font-medium text-sm text-gray-700 mb-2">Guru Terkait</label>
                                <select id="guruSelect" name="guru[]" multiple
                                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full">
                                    @foreach($guru as $g)
                                        <option value="{{ $g->id }}" @if(isset($mata_pelajaran_guru) && in_array($g->id, $mata_pelajaran_guru)) selected @endif>
                                            {{ $g->nama }} ({{ $g->nip ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('guru')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tombol --}}
                            <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-100">
                                <a href="{{ route('mata_pelajaran.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                    Kembali
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    {{ isset($mata_pelajaran) ? 'Perbarui' : 'Simpan' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('afterAppScripts')
    <!-- Tom Select CSS/JS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <style>
        /* Modern Indigo Styling for TomSelect */
        .ts-control {
            border-radius: 0.375rem; /* rounded-md */
            border-color: #d1d5db; /* gray-300 */
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        .ts-control.focus {
            border-color: #a5b4fc; /* indigo-300 */
            box-shadow: 0 0 0 3px rgba(199, 210, 254, 0.5); /* ring-indigo-200 */
        }
        
        .ts-control .item {
            background-color: #e0e7ff; /* indigo-100 */
            color: #4338ca; /* indigo-700 */
            border-radius: 9999px;
            padding: 2px 8px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .ts-control .item .remove {
            color: #4338ca; /* indigo-700 */
            border-left: 1px solid #c7d2fe; /* indigo-200 */
        }
        
        .ts-control .item .remove:hover {
            background-color: #c7d2fe; /* indigo-200 */
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
                        return '<div class="px-3 py-2 hover:bg-indigo-50">' + escape(data.text) + '</div>';
                    },
                    item: function (data, escape) {
                        return '<div>' + escape(data.text) + '</div>';
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