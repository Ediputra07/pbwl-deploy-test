@extends('layouts.bootstrap')
@section('title', 'Klien API Mata Kuliah')
@section('content')
<h3>Klien API Mata Kuliah</h3>
<div id="alert-area"></div>
 
<div class="card card-body mb-3">
    <div id="form-login" class="row g-2">
        <div class="col-md-4"><input type="email" id="login-email" class="form-control" placeholder="Email"></div>
        <div class="col-md-4"><input type="password" id="login-password" class="form-control" placeholder="Password"></div>
        <div class="col-md-2"><button type="button" id="btn-login" class="btn btn-primary w-100">Login</button></div>
        <small class="text-danger" id="err-login"></small>
    </div>
    <div id="info-user" class="d-none">
        Masuk sebagai <strong id="nama-user"></strong>
        <button type="button" id="btn-logout" class="btn btn-outline-secondary btn-sm ms-2">Logout</button>
    </div>
</div>
 
<div id="kartu-form" class="card card-body mb-3 d-none">
    <form id="form-mk" class="row g-2" novalidate>
        <input type="hidden" id="mk-id">
        <div class="col-md-4"><select id="mk-program_studi_id" class="form-select"><option value="">-- Prodi --</option></select>
            <small class="text-danger" id="err-program_studi_id"></small></div>
        <div class="col-md-2"><input id="mk-kode_mk" class="form-control" placeholder="Kode">
            <small class="text-danger" id="err-kode_mk"></small></div>
        <div class="col-md-4"><input id="mk-nama_mk" class="form-control" placeholder="Nama mata kuliah">
            <small class="text-danger" id="err-nama_mk"></small></div>
        <div class="col-md-2"><input type="number" id="mk-sks" class="form-control" placeholder="SKS">
            <small class="text-danger" id="err-sks"></small></div>
        <div class="col-md-4"><label><input type="checkbox" id="mk-status_aktif"> Aktif / dibuka</label>
            <small class="text-danger" id="err-status_aktif"></small></div>
        <div class="col-md-4"><input type="date" id="mk-tanggal_dibuka" class="form-control">
            <small class="text-danger" id="err-tanggal_dibuka"></small></div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" id="btn-batal" class="btn btn-secondary">Batal</button>
        </div>
    </form>
</div>
 
<form id="form-filter" class="row g-2 mb-3">
    <div class="col-md-5"><input id="filter-cari" class="form-control" placeholder="Cari kode / nama..."></div>
    <div class="col-md-4"><select id="filter-prodi" class="form-select"><option value="">Semua Prodi</option></select></div>
    <div class="col-md-3"><button class="btn btn-outline-primary w-100">Cari</button></div>
</form>
<button type="button" id="btn-tambah" class="btn btn-primary mb-2 d-none">+ Tambah</button>
 
<table class="table table-bordered">
    <thead><tr><th>No</th><th>Kode</th><th>Nama</th><th>SKS</th><th>Prodi</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody id="tbody-mk"></tbody>
</table>
<span id="info-halaman"></span>
<button type="button" id="btn-prev" class="btn btn-sm btn-outline-secondary">&laquo;</button>
<button type="button" id="btn-next" class="btn btn-sm btn-outline-secondary">&raquo;</button>
@endsection
 
@push('scripts')
<script src="{{ asset('js/mata-kuliah-client.js') }}"></script>
@endpush