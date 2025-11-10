<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\MataPelajaranKelas;
use App\Models\Kelas;
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
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('mata_pelajaran.form', compact('kelas'));
    }


    /**
     * Simpan data mata pelajaran baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelajaran' => 'required|string|max:255',
            'kelas' => 'array', // kelas bisa lebih dari satu
            'kelas.*' => 'exists:kelas,id',
        ]);

        $mapel = MataPelajaran::create([
            'nama_pelajaran' => $request->nama_pelajaran,
        ]);

        if ($request->has('kelas')) {
            foreach ($request->kelas as $id_kelas) {
                MataPelajaranKelas::create([
                    'id_mata_pelajaran' => $mapel->id,
                    'id_kelas' => $id_kelas,
                ]);
            }
        }

        return redirect()->route('mata_pelajaran.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit mata pelajaran
     */
    public function edit(MataPelajaran $mata_pelajaran)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('mata_pelajaran.form', compact('mata_pelajaran', 'kelas'));
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

        MataPelajaranKelas::where('id_mata_pelajaran', $mata_pelajaran->id)->delete();

        if ($request->has('kelas')) {
            foreach ($request->kelas as $id_kelas) {
                MataPelajaranKelas::create([
                    'id_mata_pelajaran' => $mata_pelajaran->id,
                    'id_kelas' => $id_kelas,
                ]);
            }
        }

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
