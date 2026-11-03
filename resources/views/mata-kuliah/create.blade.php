@extends('layouts.bootstrap')
@section('title', 'Tambah Mata Kuliah')
@section('content')
<h3>Tambah Mata Kuliah</h3>
<form action="{{ route('mata-kuliah.store') }}" method="POST">
    @csrf
    @include('mata-kuliah._form')
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('mata-kuliah.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
