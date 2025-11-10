<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaranKelas;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;

class MataPelajaranKelasController extends Controller
{
    /**
     * Tampilkan daftar relasi mata pelajaran dan kelas
     */
    public function index()
    {
        $data = MataPelajaranKelas::with(['mataPelajaran', 'kelas'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('mata_pelajaran_kelas.index', compact('data'));
    }

    /**
     * Form tambah relasi baru
     */
    public function create()
    {
        $mata_pelajaran = MataPelajaran::orderBy('nama_pelajaran')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('mata_pelajaran_kelas.form', compact('mata_pelajaran', 'kelas'));
    }

    /**
     * Simpan relasi baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_mata_pelajaran' => 'required|exists:mata_pelajaran,id',
            'id_kelas' => 'required|exists:kelas,id',
        ]);

        // Cegah duplikasi relasi
        $exists = MataPelajaranKelas::where('id_mata_pelajaran', $request->id_mata_pelajaran)
            ->where('id_kelas', $request->id_kelas)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Relasi mata pelajaran dan kelas ini sudah ada.');
        }

        MataPelajaranKelas::create([
            'id_mata_pelajaran' => $request->id_mata_pelajaran,
            'id_kelas' => $request->id_kelas,
        ]);

        return redirect()->route('mata_pelajaran_kelas.index')->with('success', 'Relasi berhasil ditambahkan.');
    }

    /**
     * Form edit relasi
     */
    public function edit(MataPelajaranKelas $mata_pelajaran_kela)
    {
        $mata_pelajaran = MataPelajaran::orderBy('nama_pelajaran')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('mata_pelajaran_kelas.form', [
            'mata_pelajaran_kela' => $mata_pelajaran_kela,
            'mata_pelajaran' => $mata_pelajaran,
            'kelas' => $kelas,
        ]);
    }

    /**
     * Update relasi yang sudah ada
     */
    public function update(Request $request, MataPelajaranKelas $mata_pelajaran_kela)
    {
        $request->validate([
            'id_mata_pelajaran' => 'required|exists:mata_pelajaran,id',
            'id_kelas' => 'required|exists:kelas,id',
        ]);

        // Cek apakah kombinasi sudah ada
        $exists = MataPelajaranKelas::where('id_mata_pelajaran', $request->id_mata_pelajaran)
            ->where('id_kelas', $request->id_kelas)
            ->where('id', '!=', $mata_pelajaran_kela->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Relasi ini sudah ada.');
        }

        $mata_pelajaran_kela->update([
            'id_mata_pelajaran' => $request->id_mata_pelajaran,
            'id_kelas' => $request->id_kelas,
        ]);

        return redirect()->route('mata_pelajaran_kelas.index')->with('success', 'Relasi berhasil diperbarui.');
    }

    /**
     * Hapus relasi
     */
    public function destroy(MataPelajaranKelas $mata_pelajaran_kela)
    {
        $mata_pelajaran_kela->delete();
        return redirect()->route('mata_pelajaran_kelas.index')->with('success', 'Relasi berhasil dihapus.');
    }
}
