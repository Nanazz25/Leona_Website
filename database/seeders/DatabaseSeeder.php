<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Murid;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            JurusanSeeder::class,
        ]);

        User::create([
            'username' => 'guruadmin',
            'password' => bcrypt('password'),
            'role' => 'kurikulum',
            'role_id' => null,
        ]);

        User::factory(9)->create();
        // Kelas::factory(1)->create();
        Guru::factory(10)->create();
        Murid::factory(10)->create();
    }
}
