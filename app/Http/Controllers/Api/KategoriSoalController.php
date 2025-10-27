<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriSoal;

class KategoriSoalController extends Controller
{
    public function index()
    {
        $kategori = KategoriSoal::orderBy('nama')->get();
        return response()->json($kategori);
    }

    public function store(Request $request)
    {
        // Validasi input kategori soal
        $request->validate([
            'nama' => 'required|string|max:255'
        ]);

        // Simpan kategori soal baru
        $kategori = KategoriSoal::create([
            'nama' => $request->nama
        ]);

        return response()->json([
            'message' => 'Kategori soal berhasil ditambahkan',
            'data' => $kategori
        ], 201);
    }

    public function show($id)
    {
        $kategori = KategoriSoal::findOrFail($id);
        return response()->json($kategori);
    }

    public function update(Request $request, $id)
    {
        // Perbarui kategori soal
        $kategori = KategoriSoal::findOrFail($id);

        // Validasi input kategori soal
        $request->validate([
            'nama' => 'required|string|max:255'
        ]);

        // Update nama kategori
        $kategori->update(['nama' => $request->nama]);

        return response()->json([
            'message' => 'Kategori soal berhasil diperbarui',
            'data' => $kategori
        ]);
    }

    public function destroy($id)
    {
        $kategori = KategoriSoal::findOrFail($id);
        $kategori->delete();

        return response()->json(['message' => 'Kategori soal berhasil dihapus']);
    }
}
