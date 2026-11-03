@extends('layouts.bootstrap')
@section('title', 'Detail Mata Kuliah')
@section('content')
<h3>{{ $mataKuliah->kode_mk }} - {{ $mataKuliah->nama_mk }}</h3>
<p>Prodi: {{ $mataKuliah->programStudi->nama }} | SKS: {{ $mataKuliah->sks }}</p>
<p>Jumlah mahasiswa: {{ $mataKuliah->mahasiswa->count() }}</p>
<a href="{{ route('mata-kuliah.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
