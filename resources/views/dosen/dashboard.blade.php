<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Dosen</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <p>Selamat Datang, {{ Auth::user()->name }}!</p>

                @can('lihat progres')
                    <div class="mt-4 p-3 bg-green-100 text-green-800 rounded">
                        Anda memiliki hak akses untuk <strong>lihat progres</strong>.
                    </div>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
