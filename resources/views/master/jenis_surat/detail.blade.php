@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Detail Jenis Surat</h3>

    <table class="table table-bordered mt-3">
        <tr>
            <th>Nama Jenis Surat</th>
            <td>{{ $data->nama_jenis }}</td>
        </tr>
        <tr>
            <th>Deskripsi</th>
            <td>{{ $data->deskripsi }}</td>
        </tr>
        <tr>
            <th>Dibuat Oleh</th>
            <td>{{ $data->created_by }}</td>
        </tr>
        <tr>
            <th>Tanggal Dibuat</th>
            <td>{{ $data->created_at }}</td>
        </tr>
    </table>

    <a href="{{ route('master.jenis_surat.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
