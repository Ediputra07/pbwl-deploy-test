@extends('layouts.bootstrap')
@section('title', 'Mata Kuliah')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Daftar Mata Kuliah</h3>
    @can('kelola-mata-kuliah')
        <a href="{{ route('mata-kuliah.create') }}" class="btn btn-primary">+ Tambah</a>
    @endcan
</div>

<form method="GET" action="{{ route('mata-kuliah.index') }}" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="cari" value="{{ request('cari') }}"
               class="form-control" placeholder="Cari kode / nama...">
    </div>
    <div class="col-md-3">
        <select name="prodi" class="form-select">
            <option value="">Semua Prodi</option>
            @foreach ($programStudi as $p)
                <option value="{{ $p->id }}" @selected(request('prodi') == $p->id)>{{ $p->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 d-flex align-items-center">
        <input type="checkbox" name="hanya_aktif" value="1" class="form-check-input me-2"
               @checked(request()->boolean('hanya_aktif'))> Hanya yang aktif
    </div>
    <div class="col-md-2"><button class="btn btn-outline-primary w-100">Cari</button></div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th><th>Kode</th><th>Nama</th><th>SKS</th>
            <th>Prodi</th><th>Peserta</th><th>Status</th><th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($mataKuliah as $mk)
        <tr>
            <td>{{ $mataKuliah->firstItem() + $loop->index }}</td>
            <td>{{ $mk->kode_mk }}</td>
            <td>{{ $mk->nama_mk }}</td>
            <td>{{ $mk->sks }}</td>
            <td>{{ $mk->programStudi->nama }}</td>
            <td>{{ $mk->mahasiswa_count }}</td>
            <td>{{ $mk->status_aktif ? 'Aktif' : 'Nonaktif' }}</td>
            <td>
                <a href="{{ route('mata-kuliah.show', $mk) }}" class="btn btn-sm btn-info">Detail</a>
                @can('update', $mk)
                    <a href="{{ route('mata-kuliah.edit', $mk) }}" class="btn btn-sm btn-warning">Ubah</a>
                @endcan
                @can('delete', $mk)
                    <form action="{{ route('mata-kuliah.destroy', $mk) }}" method="POST"
                          class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                @endcan
            </td>
        </tr>
    @empty
        <tr><td colspan="8" class="text-center">Belum ada data.</td></tr>
    @endforelse
    </tbody>
</table>

{{ $mataKuliah->links() }}
@endsection
