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
        return [
            'kode_prodi' => fake()->unique()->randomElement(['SI', 'TI', 'MI']),
            'nama'       => fake()->randomElement([
                'Sistem Informasi',
                'Teknik Informatika',
                'Manajemen Informatika',
            ]),
        ];
    }
}
