@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Tambah Jenis Surat</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('master.jenis_surat.create') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Jenis Surat</label>
            <input type="text" name="nama_jenis" class="form-control" value="{{ old('nama_jenis') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('master.jenis_surat.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
