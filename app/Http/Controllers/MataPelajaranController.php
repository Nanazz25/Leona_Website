<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    /**
     * Tampilkan daftar mata pelajaran
     */
    public function index()
    {
        $mapel = MataPelajaran::orderBy('created_at', 'desc')->paginate(10);
        return view('mata_pelajaran.index', compact('mapel'));
    }

    /**
     * Tampilkan form tambah mata pelajaran
     */
    public function create()
    {
        return view('mata_pelajaran.form');
    }

    /**
     * Simpan data mata pelajaran baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelajaran' => 'required|string|max:255',
        ]);

        MataPelajaran::create([
            'nama_pelajaran' => $request->nama_pelajaran,
        ]);

        return redirect()->route('mata_pelajaran.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit mata pelajaran
     */
    public function edit(MataPelajaran $mata_pelajaran)
    {
        return view('mata_pelajaran.form', compact('mata_pelajaran'));
    }

    /**
     * Update data mata pelajaran
     */
    public function update(Request $request, MataPelajaran $mata_pelajaran)
    {
        $request->validate([
            'nama_pelajaran' => 'required|string|max:255',
        ]);

        $mata_pelajaran->update([
            'nama_pelajaran' => $request->nama_pelajaran,
        ]);

        return redirect()->route('mata_pelajaran.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    /**
     * Hapus mata pelajaran
     */
    public function destroy(MataPelajaran $mata_pelajaran)
    {
        $mata_pelajaran->delete();
        return redirect()->route('mata_pelajaran.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
