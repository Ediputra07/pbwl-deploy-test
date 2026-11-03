<?php

namespace Database\Factories;

use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProgramStudi>
 */
class ProgramStudiFactory extends Factory
{
    public function definition(): array
    {
        // Kode dan nama dipilih sebagai satu pasangan agar selalu cocok dan tidak kembar
        [$kode, $nama] = fake()->unique()->randomElement([
            ['SI', 'Sistem Informasi'],
            ['TI', 'Teknik Informatika'],
            ['MI', 'Manajemen Informatika'],
        ]);

        return [
            'kode_prodi' => $kode,
            'nama'       => $nama,
        ];
    }
}
