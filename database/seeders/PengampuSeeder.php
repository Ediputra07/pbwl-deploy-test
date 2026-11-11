<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PengampuSeeder extends Seeder
{
    public function run(): void
    {
        $dosenA = User::where('email', 'dosen@gmail.com')
            ->firstOrFail();

        $dosenB = User::firstOrCreate(
            ['email' => 'dosen2@gmail.com'],
            ['name' => 'Bu Dosen', 'password' => Hash::make('password')]
        );
        $dosenB->assignRole('dosen');

        MataKuliah::orderBy('id')->get()->each(
            function (MataKuliah $mk, int $i) use ($dosenA, $dosenB) {
                $mk->user_id = $i % 2 === 0 ? $dosenA->id : $dosenB->id;
                $mk->save();
            }
        );
    }
}
