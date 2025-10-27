<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function store(Request $request)
    {
        // Buat sesi absensi (per kelas per tanggal)
        $request->validate([
            'id_kelas' => 'required|exists:kelas,id',
        ]);

        // Cek apakah sudah ada sesi absensi untuk kelas dan tanggal yang sama
        $absensi = Absensi::create([
            'id_kelas' => $request->id_kelas,
            'id_guru' => auth()->user()->role_id, // guru yang sedang login
            'tanggal' => now(), // auto dateTime
        ]);

        return response()->json([
            'message' => 'Sesi absensi berhasil dibuat.',
            'data' => $absensi
        ], 201);
    }

    public function index(Request $request)
    {
        // Lihat daftar absensi (bisa filter kelas ? tanggal)
        $request->validate([
            'id_kelas' => 'required|exists:kelas,id'
        ]);

        $query = Absensi::with('kelas', 'guru')
            ->where('id_kelas', $request->id_kelas)
            ->orderBy('tanggal', 'desc');

        // opsional filter tanggal (yyyy-mm-dd)
        if ($request->has('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        return response()->json($query->get());
    }

    public function show($id)
    {
        // Detail absensi + murid
        $data = Absensi::with(['kelas', 'guru', 'detail.murid'])
            ->findOrFail($id);

        return response()->json($data);
    }
}
