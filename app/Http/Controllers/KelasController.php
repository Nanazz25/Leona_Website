<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('jurusan')->orderBy('created_at', 'desc')->paginate(10);
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        return view('kelas.form', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tingkat_kelas' => 'required|in:10,11,12',
            'id_jurusan' => 'required|exists:jurusan,id',
        ]);

        $jurusan = Jurusan::findOrFail($request->id_jurusan);

        $count = Kelas::where('tingkat_kelas', $request->tingkat_kelas)
            ->where('id_jurusan', $request->id_jurusan)
            ->count();

        $nextNumber = $count + 1;

        $namaKelas = "{$request->tingkat_kelas} {$jurusan->nama_jurusan} {$nextNumber}";

        Kelas::create([
            'tingkat_kelas' => $request->tingkat_kelas,
            'id_jurusan' => $request->id_jurusan,
            'nama_kelas' => $namaKelas,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kela)
    {
        $jurusans = Jurusan::all();
        return view('kelas.form', ['kelas' => $kela, 'jurusans' => $jurusans]);
    }

    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'tingkat_kelas' => 'required|in:10,11,12',
            'id_jurusan' => 'required|exists:jurusan,id',
        ]);

        $jurusan = Jurusan::findOrFail($request->id_jurusan);

        // Ambil angka urutan lama
        $oldNumber = explode(' ', $kela->nama_kelas);
        $oldNumber = end($oldNumber);

        $namaKelas = "{$request->tingkat_kelas} {$jurusan->nama_jurusan} {$oldNumber}";

        $kela->update([
            'tingkat_kelas' => $request->tingkat_kelas,
            'id_jurusan' => $request->id_jurusan,
            'nama_kelas' => $namaKelas,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
