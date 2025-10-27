<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AbsensiDetail;
use Illuminate\Http\Request;

class AbsensiDetailController extends Controller
{
    public function store(Request $request, $id_absensi)
    {
        // Tambah detail absensi (kehadiran murid)
        $request->validate([
            'id_murid' => 'required|exists:murid,id',
            'kehadiran' => 'required|in:hadir,izin,sakit,alfa',
            'keterangan' => 'nullable',
        ]);

        // Simpan atau perbarui detail absensi
        $detail = AbsensiDetail::updateOrCreate(
            [
                'id_absensi' => $id_absensi,
                'id_murid' => $request->id_murid
            ],
            [
                'kehadiran' => $request->kehadiran,
                'keterangan' => $request->keterangan
            ]
        );

        return response()->json([
            'message' => 'Absensi murid berhasil disimpan.',
            'data' => $detail
        ], 201);
    }
}
