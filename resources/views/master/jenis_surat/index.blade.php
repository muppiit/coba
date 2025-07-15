@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Jenis Surat</h3>
        <a href="{{ route('master.jenis_surat.add') }}" class="btn btn-success">+ Tambah Jenis Surat</a>
    </div>

    {{-- Pencarian --}}
    <form method="GET" action="{{ route('master.jenis_surat.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari jenis surat..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($data->count())
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Jenis Surat</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $item)
                <tr>
                    <td>{{ $i + $data->firstItem() }}</td>
                    <td>{{ $item->nama_jenis }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    <td>
                        <a href="{{ route('master.jenis_surat.detail', $item->id) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('master.jenis_surat.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ route('master.jenis_surat.delete', $item->id) }}" class="btn btn-sm btn-danger">Hapus</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        {{ $data->withQueryString()->links() }}
    @else
        <div class="alert alert-info">Belum ada data jenis surat.</div>
    @endif
</div>
@endsection
