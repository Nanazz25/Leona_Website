<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * Tampilkan daftar jurusan
     */
    public function index()
    {
        $jurusans = Jurusan::all();
        return view('jurusan.index', compact('jurusans'));
    }

    /**
     * Tampilkan form tambah jurusan
     */
    public function create()
    {
        return view('jurusan.create');
    }

    /**
     * Simpan data jurusan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
        ]);

        Jurusan::create([
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit
     */
    public function edit(Jurusan $jurusan)
    {
        return view('jurusan.edit', compact('jurusan'));
    }

    /**
     * Update data jurusan
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
        ]);

        $jurusan->update([
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    /**
     * Hapus jurusan
     */
    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}
