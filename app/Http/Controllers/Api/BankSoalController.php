<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankSoal;
use Illuminate\Support\Facades\Auth;

class BankSoalController extends Controller
{
    public function index(Request $request)
    {
        $query = BankSoal::with('kategori', 'guru');

        // filter pencarian teks
        if ($request->has('search')) {
            $keyword = $request->search;
            $query->where('pertanyaan', 'like', "%{$keyword}%");
        }

        // filter berdasarkan kategori
        if ($request->has('kategori_id')) {
            $query->where('id_kategori_soal', $request->kategori_id);
        }

        // filter soal buatan sendiri
        if ($request->boolean('mine')) {
            $query->where('created_by', Auth::user()->role_id);
        }

        // pagination (default 10 per halaman)
        $perPage = $request->get('per_page', 10);
        $soal = $query->latest()->paginate($perPage);

        return response()->json($soal);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'jawaban_benar' => 'required|in:A,B,C,D',
            'id_kategori_soal' => 'required|exists:kategori_soal,id'
        ]);

        $soal = BankSoal::create([
            'pertanyaan' => $request->pertanyaan,
            'opsi_a' => $request->opsi_a,
            'opsi_b' => $request->opsi_b,
            'opsi_c' => $request->opsi_c,
            'opsi_d' => $request->opsi_d,
            'jawaban_benar' => $request->jawaban_benar,
            'id_kategori_soal' => $request->id_kategori_soal,
            'created_by' => Auth::user()->role_id
        ]);

        return response()->json(['message' => 'Soal berhasil ditambahkan', 'data' => $soal], 201);
    }

    public function show($id)
    {
        $soal = BankSoal::with('kategori', 'guru')->findOrFail($id);
        return response()->json($soal);
    }

    public function update(Request $request, $id)
    {
        $soal = BankSoal::findOrFail($id);

        // hanya bisa edit soal yang dibuat sendiri
        if ($soal->created_by !== Auth::user()->role_id) {
            return response()->json(['message' => 'Tidak bisa mengedit soal milik guru lain'], 403);
        }

        $request->validate([
            'pertanyaan' => 'sometimes|string',
            'opsi_a' => 'sometimes|string',
            'opsi_b' => 'sometimes|string',
            'opsi_c' => 'sometimes|string',
            'opsi_d' => 'sometimes|string',
            'jawaban_benar' => 'sometimes|in:A,B,C,D',
            'id_kategori_soal' => 'sometimes|exists:kategori_soal,id'
        ]);

        $soal->update($request->all());
        return response()->json(['message' => 'Soal berhasil diperbarui', 'data' => $soal]);
    }

    public function destroy($id)
    {
        $soal = BankSoal::findOrFail($id);

        // hanya bisa hapus soal sendiri
        if ($soal->created_by !== Auth::user()->role_id) {
            return response()->json(['message' => 'Tidak bisa menghapus soal milik guru lain'], 403);
        }

        $soal->delete();

        return response()->json(['message' => 'Soal berhasil dihapus']);
    }
}
