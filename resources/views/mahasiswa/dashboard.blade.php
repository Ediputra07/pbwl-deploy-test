<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Mahasiswa</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <p>Selamat Datang, {{ Auth::user()->name }}!</p>

                <p class="mt-2 text-gray-600">Anda masuk sebagai mahasiswa.</p>
            </div>
        </div>
    </div>
</x-app-layout>
