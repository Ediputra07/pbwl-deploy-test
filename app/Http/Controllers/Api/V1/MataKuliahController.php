<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMataKuliahRequest;
use App\Http\Requests\UpdateMataKuliahRequest;
use App\Http\Resources\V1\MataKuliahResource;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class MataKuliahController extends Controller
{
    public function index(Request $request)
    {
        $data = MataKuliah::with('programStudi')->withCount('mahasiswa')
            ->when($request->filled('cari'), fn ($q) => $q->where(fn ($w) => $w
                ->where('nama_mk', 'like', '%'.$request->cari.'%')
                ->orWhere('kode_mk', 'like', '%'.$request->cari.'%')))
            ->when($request->filled('prodi'), fn ($q) => $q->where('program_studi_id', $request->prodi))
            ->latest('id')->paginate(10)->withQueryString();

        return MataKuliahResource::collection($data);
    }

    #[Middleware('auth:sanctum')]
    public function store(StoreMataKuliahRequest $request)
    {
        Gate::authorize('kelola-mata-kuliah');

        $mk = MataKuliah::create($request->validated());

        return (new MataKuliahResource($mk->load('programStudi')->loadCount('mahasiswa')))
            ->response()->setStatusCode(201);
    }

    public function show(MataKuliah $mataKuliah)
    {
        return new MataKuliahResource($mataKuliah->load('programStudi')->loadCount('mahasiswa'));
    }

    #[Middleware('auth:sanctum')]
    public function update(UpdateMataKuliahRequest $request, MataKuliah $mataKuliah)
    {
        Gate::authorize('update', $mataKuliah);

        $mataKuliah->update($request->validated());

        return new MataKuliahResource($mataKuliah->load('programStudi')->loadCount('mahasiswa'));
    }

    #[Middleware('auth:sanctum')]
    public function destroy(MataKuliah $mataKuliah)
    {
        Gate::authorize('delete', $mataKuliah);

        $mataKuliah->delete();

        return response()->noContent();
    }
}
