@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Surat</h3>
        <a href="{{ route('transaction.surat.add') }}" class="btn btn-success">+ Tambah Surat</a>
        <a href="{{ route('master.jenis_surat.index') }}" class="btn btn-success">+ Tambah Jenis Surat</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($data->count())
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Surat</th>
                    <th>Jenis Surat</th>
                    <th>Pengirim</th>
                    <th>Penerima</th>
                    <th>Tanggal Surat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $item)
                <tr>
                    <td>{{ $i + $data->firstItem() }}</td>
                    <td>{{ $item->nomor_surat }}</td>
                    <td>{{ $item->jenisSurat->nama_jenis ?? '-' }}</td>
                    <td>{{ $item->pengirim }}</td>
                    <td>{{ $item->penerima }}</td>
                    <td>{{ $item->tanggal_surat }}</td>
                    <td>
                        <a href="{{ route('transaction.surat.detail', $item->id) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('transaction.surat.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ route('transaction.surat.delete', $item->id) }}" class="btn btn-sm btn-danger">Hapus</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $data->links() }}
    @else
        <div class="alert alert-info">Belum ada data surat.</div>
    @endif
</div>
@endsection
