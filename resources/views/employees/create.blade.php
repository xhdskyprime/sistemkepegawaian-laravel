@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Pegawai</h2>
    <form action="{{ route('employees.store') }}" method="POST">
        @csrf
        @include('employees.form')
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
