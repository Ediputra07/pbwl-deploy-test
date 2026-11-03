<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMataKuliahRequest;
use App\Http\Requests\UpdateMataKuliahRequest;
use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index(Request $request)
    {
        $mataKuliah = MataKuliah::with('programStudi')
            ->withCount('mahasiswa')
            ->when($request->filled('cari'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('nama_mk', 'like', '%' . $request->cari . '%')
                      ->orWhere('kode_mk', 'like', '%' . $request->cari . '%');
                });
            })
            ->when($request->filled('prodi'), fn ($q) => $q->where('program_studi_id', $request->prodi))
            ->when($request->boolean('hanya_aktif'), fn ($q) => $q->dibuka())
            ->latest()
            ->paginate(10)
            ->withQueryString(); // agar parameter cari/filter terbawa saat pindah halaman

        return view('mata-kuliah.index', [
            'mataKuliah'   => $mataKuliah,
            'programStudi' => ProgramStudi::orderBy('nama')->get(),
        ]);
    }

    public function create()
    {
        return view('mata-kuliah.create', [
            'mataKuliah'   => new MataKuliah(),
            'programStudi' => ProgramStudi::orderBy('nama')->get(),
        ]);
    }

    public function store(StoreMataKuliahRequest $request)
    {
        MataKuliah::create($request->validated());

        return redirect()->route('mata-kuliah.index')
                         ->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function show(MataKuliah $mataKuliah)
    {
        $mataKuliah->load(['programStudi', 'mahasiswa']);

        return view('mata-kuliah.show', compact('mataKuliah'));
    }

    public function edit(MataKuliah $mataKuliah)
    {
        return view('mata-kuliah.edit', [
            'mataKuliah'   => $mataKuliah,
            'programStudi' => ProgramStudi::orderBy('nama')->get(),
        ]);
    }

    public function update(UpdateMataKuliahRequest $request, MataKuliah $mataKuliah)
    {
        $mataKuliah->update($request->validated());

        return redirect()->route('mata-kuliah.index')
                         ->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function destroy(MataKuliah $mataKuliah)
    {
        $mataKuliah->delete();

        return redirect()->route('mata-kuliah.index')
                         ->with('success', 'Mata kuliah berhasil dihapus.');
    }
}
