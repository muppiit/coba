@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Detail Surat</h3>

    <table class="table table-bordered mt-3">
        <tr>
            <th>Nomor Surat</th>
            <td>{{ $data->nomor_surat }}</td>
        </tr>
        <tr>
            <th>Jenis Surat</th>
            <td>{{ $data->jenisSurat->nama_jenis ?? '-' }}</td>
        </tr>
        <tr>
            <th>Pengirim</th>
            <td>{{ $data->pengirim }}</td>
        </tr>
        <tr>
            <th>Penerima</th>
            <td>{{ $data->penerima }}</td>
        </tr>
        <tr>
            <th>Tanggal Surat</th>
            <td>{{ $data->tanggal_surat }}</td>
        </tr>
    </table>

    <a href="{{ route('transaction.surat.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
