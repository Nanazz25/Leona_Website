<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use App\Models\Kelas;
use Illuminate\Http\Request;

class MuridController extends Controller
{
    /**
     * Tampilkan semua data murid (10 per halaman, terbaru di atas)
     */
    public function index()
    {
        $murid = Murid::with('kelas')->orderBy('created_at', 'desc')->paginate(10);
        return view('murid.index', compact('murid'));
    }

    /**
     * Tampilkan form tambah murid
     */
    public function create()
    {
        $kelas = Kelas::all();
        // Gunakan view form tunggal
        return view('murid.form', compact('kelas'));
    }

    /**
     * Simpan data murid baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nisn' => 'required|string|max:30|unique:murid,nisn',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'id_kelas' => 'required|exists:kelas,id',
        ]);

        Murid::create($request->only(['nama', 'nisn', 'jenis_kelamin', 'id_kelas']));

        return redirect()
            ->route('murid.index')
            ->with('success', '✅ Data murid berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit murid
     */
    public function edit($id)
    {
        $murid = Murid::findOrFail($id);
        $kelas = Kelas::all();
        // Gunakan view yang sama seperti create
        return view('murid.form', compact('murid', 'kelas'));
    }

    /**
     * Update data murid
     */
    public function update(Request $request, $id)
    {
        $murid = Murid::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'nisn' => 'required|string|max:30|unique:murid,nisn,' . $murid->id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'id_kelas' => 'required|exists:kelas,id',
        ]);

        $murid->update($request->only(['nama', 'nisn', 'jenis_kelamin', 'id_kelas']));

        return redirect()
            ->route('murid.index')
            ->with('success', '✏️ Data murid berhasil diperbarui!');
    }

    /**
     * Hapus data murid
     */
    public function destroy($id)
    {
        $murid = Murid::findOrFail($id);
        $murid->delete();

        return redirect()
            ->route('murid.index')
            ->with('success', '🗑️ Data murid berhasil dihapus.');
    }
}
