<?php

namespace Database\Factories;

use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MataKuliah>
 */
class MataKuliahFactory extends Factory
{
    public function definition(): array
    {
        return [
            'program_studi_id' => ProgramStudi::factory(),
            'kode_mk'          => strtoupper(fake()->unique()->bothify('MK-###')),
            'nama_mk'          => fake()->words(3, true),
            'sks'              => fake()->numberBetween(1, 4),
            'status_aktif'     => false,
            'tanggal_dibuka'   => null,
        ];
    }

    // State: variasi data
    public function dibuka(): static
    {
        return $this->state(fn (array $atribut) => [
            'status_aktif'   => true,
            'tanggal_dibuka' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }
}
