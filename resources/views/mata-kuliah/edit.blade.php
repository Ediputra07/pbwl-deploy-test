@extends('layouts.bootstrap')
@section('title', 'Ubah Mata Kuliah')
@section('content')
<h3>Ubah Mata Kuliah</h3>
<form action="{{ route('mata-kuliah.update', $mataKuliah) }}" method="POST">
    @csrf
    @method('PUT')
    @include('mata-kuliah._form')
    <button class="btn btn-primary">Perbarui</button>
    <a href="{{ route('mata-kuliah.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
