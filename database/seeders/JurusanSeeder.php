<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    public function run()
    {
        $jurusanList = ['PPLG', 'Akkul', 'MPLB', 'PS', 'TJKT'];

        foreach ($jurusanList as $jurusan) {
            Jurusan::create([
                'nama_jurusan' => $jurusan
            ]);
        }
    }
}

