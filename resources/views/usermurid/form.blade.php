```
@extends('layouts.app')

@section('title', isset($user) ? 'Edit User Murid' : 'Tambah User Murid')
@section('namaPage', 'User Murid')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="flex justify-center">
            <div class="w-full md:w-2/3">

                        <form method="POST"
                            action="{{ isset($user) ? route('usermurid.update', $user->id) : route('usermurid.store') }}">
                            @csrf
                            @if (isset($user))
                                @method('PUT')
                            @endif

                            <input type="hidden" name="id_kelas" value="{{ $kelas->id }}">
                            
                            {{-- Hidden inputs to store selected murid data --}}
                            <input type="hidden" name="murid_id" id="murid_id" value="{{ old('murid_id', $murid->id ?? '') }}">
                            <input type="hidden" name="nama" id="nama_hidden" value="{{ old('nama', $murid->nama ?? '') }}">
                            <input type="hidden" name="nisn" id="nisn_hidden" value="{{ old('nisn', $murid->nisn ?? '') }}">

                            {{-- Search / Selection UI --}}
                            <div class="mb-6 relative">
                                <label class="block font-medium text-sm text-gray-700 mb-2">Cari Murid</label>
                                
                                {{-- Search Input --}}
                                <div id="search-container" class="{{ isset($murid) ? 'hidden' : '' }} relative">
                                    <div class="relative">
                                        <input type="text" id="search-input" 
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full pl-10" 
                                            placeholder="Ketuk untuk mencari murid..." autocomplete="off">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="bi bi-search text-gray-400"></i>
                                        </div>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" id="search-chevron">
                                            <i class="bi bi-chevron-down text-gray-400"></i>
                                        </div>
                                    </div>

                                    <div id="search-results" class="absolute z-50 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm hidden">
                                        {{-- Results via JS --}}
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Ketuk kolom untuk menampilkan daftar murid yang belum memiliki akun.</p>
                                </div>

                                {{-- Selected Tag UI --}}
                                <div id="selected-container" class="{{ isset($murid) ? '' : 'hidden' }}">
                                    <div class="bg-indigo-50 border border-indigo-200 rounded-md p-4 flex justify-between items-center">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 bg-indigo-100 rounded-full p-2">
                                                <i class="bi bi-person-fill text-indigo-600 text-xl"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-indigo-900" id="display-nama">{{ $murid->nama ?? '' }}</p>
                                                <p class="text-sm text-indigo-700">NISN: <span id="display-nisn">{{ $murid->nisn ?? '' }}</span></p>
                                            </div>
                                        </div>
                                        <button type="button" class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 px-3 py-1 rounded-md text-sm font-medium transition-colors duration-200" id="btn-cancel-selection">
                                            <i class="bi bi-x-lg mr-1"></i> Ganti
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Auto Username Preview --}}
                            <div class="mb-6">
                                <label class="block font-medium text-sm text-gray-700 mb-2">Username (Auto-Generated)</label>
                                <input type="text" class="bg-gray-100 border-gray-300 text-gray-500 rounded-md shadow-sm block w-full cursor-not-allowed" id="username-preview" readonly 
                                    value="{{ isset($user) ? $user->username : 'Akan muncul setelah memilih murid...' }}">
                                <p class="mt-1 text-sm text-gray-500">Format: MUR-[NAMA]-[3 DIGIT TERAKHIR NISN]</p>
                            </div>

                            <div class="mb-6">
                                <label class="block font-medium text-sm text-gray-700 mb-2">Password {{ isset($user) ? '(Kosongkan jika tidak ingin mengubah)' : '' }}</label>
                                <input type="password" name="password"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full @error('password') border-red-500 @enderror"
                                    {{ isset($user) ? '' : 'required' }}>
                                @error('password')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-100">
                                <a href="{{ route('usermurid.murid', $kelas->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                    Kembali
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150" id="btn-save">
                                    Simpan
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const searchResults = document.getElementById('search-results');
        const searchContainer = document.getElementById('search-container');
        const selectedContainer = document.getElementById('selected-container');
        const btnCancel = document.getElementById('btn-cancel-selection');
        const searchChevron = document.getElementById('search-chevron');
        
        const muridIdInput = document.getElementById('murid_id');
        const namaHiddenInput = document.getElementById('nama_hidden');
        const nisnHiddenInput = document.getElementById('nisn_hidden');
        
        const displayNama = document.getElementById('display-nama');
        const displayNisn = document.getElementById('display-nisn');
        const usernamePreview = document.getElementById('username-preview');

        let debounceTimeout;

        // Function to perform search
        function performSearch(query = '') {
            const excludeUserId = '{{ $user->id ?? "" }}';
            
            // Show loading state
            searchResults.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500 text-center">Memuat data...</div>';
            searchResults.classList.remove('hidden');

            fetch(`{{ route('usermurid.search') }}?q=${encodeURIComponent(query)}&exclude_user_id=${excludeUserId}`)
                .then(response => response.json())
                .then(data => {
                    searchResults.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            const div = document.createElement('div');
                            div.className = 'cursor-pointer select-none relative py-2 pl-4 pr-4 hover:bg-indigo-50 transition-colors duration-150 border-b border-gray-50 last:border-b-0';
                            div.innerHTML = `
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="block font-medium text-gray-900">${item.nama}</span>
                                        <span class="block text-xs text-gray-500">NISN: ${item.nisn} | ${item.kelas_nama}</span>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        Pilih
                                    </span>
                                </div>
                            `;
                            div.addEventListener('click', (e) => {
                                e.preventDefault();
                                selectMurid(item);
                            });
                            searchResults.appendChild(div);
                        });
                    } else {
                        searchResults.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500 text-center">Tidak ada murid ditemukan (atau sudah punya akun).</div>';
                    }
                    searchResults.classList.remove('hidden');
                })
                .catch(err => {
                    searchResults.innerHTML = '<div class="px-4 py-3 text-sm text-red-500 text-center">Gagal memuat data.</div>';
                });
        }

        // Search Input Event (Typing)
        searchInput.addEventListener('input', function() {
            const query = this.value;
            clearTimeout(debounceTimeout);

            debounceTimeout = setTimeout(() => {
                performSearch(query);
            }, 300);
        });

        // Focus Event - Show results immediately
        searchInput.addEventListener('focus', function() {
            performSearch(this.value);
        });

        // Click on Chevron - Toggle results
        searchChevron.addEventListener('click', function() {
            if (!searchResults.classList.contains('hidden')) {
                searchResults.classList.add('hidden');
            } else {
                searchInput.focus();
            }
        });

        // Hide dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && 
                !searchResults.contains(e.target) && 
                !searchChevron.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });

        // Select Murid Function
        function selectMurid(item) {
            // Fill hidden inputs
            muridIdInput.value = item.id;
            namaHiddenInput.value = item.nama;
            nisnHiddenInput.value = item.nisn;

            // Update UI
            displayNama.textContent = item.nama;
            displayNisn.textContent = item.nisn;
            
            searchContainer.classList.add('hidden');
            selectedContainer.classList.remove('hidden');
            searchResults.classList.add('hidden');
            searchInput.value = ''; // Clear search

            // Generate Username Preview
            generateUsernamePreview(item.nama, item.nisn);
        }

        // Cancel Selection
        btnCancel.addEventListener('click', function() {
            // Clear inputs
            muridIdInput.value = '';
            namaHiddenInput.value = '';
            nisnHiddenInput.value = '';

            // Update UI
            selectedContainer.classList.add('hidden');
            searchContainer.classList.remove('hidden');
            
            // Reset username preview if creating new
            @if(!isset($user))
                usernamePreview.value = 'Akan muncul setelah memilih murid...';
            @endif
            
            // Focus back to search
            setTimeout(() => searchInput.focus(), 100);
        });

        function generateUsernamePreview(nama, nisn) {
            // Simple client-side preview, actual generation is server-side
            // Logic: MUR-[NAMA_SLUG]-[LAST 3 NISN]
            // Example: Muthia (1234) -> MUR-MUTHIA234
            
            // Get first name or slug
            const slug = nama.replace(/[^a-zA-Z0-9 ]/g, '').split(' ')[0].toUpperCase();
            
            // Get last 3 digits of NISN
            const nisnStr = nisn.toString();
            const nisnSuffix = nisnStr.length >= 3 ? nisnStr.slice(-3) : nisnStr;
            
            const preview = `MUR-${slug}${nisnSuffix}`;
            usernamePreview.value = preview;
        }
    });
</script>
@endsection
```