@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Edit Surat</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('transaction.surat.update', $data->id) }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nomor Surat</label>
            <input type="text" name="nomor_surat" class="form-control" value="{{ old('nomor_surat', $data->nomor_surat) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Surat</label>
            <select name="fk_m_jenis_surat" class="form-select" required>
                <option value="">-- Pilih Jenis Surat --</option>
                @foreach($jenisSurat as $jenis)
                    <option value="{{ $jenis->id }}" {{ old('fk_m_jenis_surat', $data->fk_m_jenis_surat) == $jenis->id ? 'selected' : '' }}>
                        {{ $jenis->nama_jenis }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Pengirim</label>
            <input type="text" name="pengirim" class="form-control" value="{{ old('pengirim', $data->pengirim) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Penerima</label>
            <input type="text" name="penerima" class="form-control" value="{{ old('penerima', $data->penerima) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Surat</label>
            <input type="date" name="tanggal_surat" class="form-control" value="{{ old('tanggal_surat', $data->tanggal_surat) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('transaction.surat.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
