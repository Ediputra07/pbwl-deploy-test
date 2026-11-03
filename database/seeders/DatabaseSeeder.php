<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserSeeder::class);

        $mahasiswa = Mahasiswa::factory(20)->create();

        ProgramStudi::factory(3)->create()->each(function ($satuProdi) use ($mahasiswa) {
            MataKuliah::factory(5)
                ->dibuka()
                ->for($satuProdi) // set program_studi_id ke prodi ini
                ->create()
                ->each(function ($satuMataKuliah) use ($mahasiswa) {
                    // daftarkan 10 mahasiswa acak ke tiap mata kuliah (isi KRS)
                    $satuMataKuliah->mahasiswa()->attach($mahasiswa->random(10)->pluck('id'));
                });
        });
    }
}
