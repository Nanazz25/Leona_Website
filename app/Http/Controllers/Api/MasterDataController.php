<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function indexKelas()
    {
        $kelas = Kelas::all();
        return response()->json(['data' => $kelas]);
    }

    public function indexJurusan()
    {
        $jurusan = Jurusan::all();
        return response()->json(['data' => $jurusan]);
    }

    public function indexMataPelajaran()
    {
        $mapel = MataPelajaran::all();
        return response()->json(['data' => $mapel]);
    }
}
