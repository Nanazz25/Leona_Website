<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Tampilkan semua data guru (10 per halaman, terbaru di atas)
     */
    public function index()
    {
        $guru = Guru::orderBy('created_at', 'desc')->paginate(10);
        return view('guru.index', compact('guru'));
    }

    /**
     * Tampilkan form tambah guru
     */
    public function create()
    {
        // Tidak buat file create.blade lagi, cukup panggil form.blade
        return view('guru.form');
    }

    /**
     * Simpan data guru baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'required|string|max:30|unique:guru,nip',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        Guru::create($request->only(['nama', 'nip', 'jenis_kelamin']));

        return redirect()
            ->route('guru.index')
            ->with('success', '✅ Data guru berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit guru
     */
    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        // Gunakan view yang sama (guru.form)
        return view('guru.form', compact('guru'));
    }

    /**
     * Update data guru
     */
    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'required|string|max:30|unique:guru,nip,' . $guru->id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        $guru->update($request->only(['nama', 'nip', 'jenis_kelamin']));

        return redirect()
            ->route('guru.index')
            ->with('success', '✏️ Data guru berhasil diperbarui!');
    }

    /**
     * Hapus data guru
     */
    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()
            ->route('guru.index')
            ->with('success', '🗑️ Data guru berhasil dihapus.');
    }
}
