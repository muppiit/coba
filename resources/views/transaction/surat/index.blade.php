@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Daftar Surat</h3>
            <a href="{{ route('transaction.surat.add') }}" class="btn btn-success">+ Tambah Surat</a>
            <a href="{{ route('master.jenis_surat.index') }}" class="btn btn-success">+ Tambah Jenis Surat</a>
            <img src="data:image/png;base64,{{ $qrCodeEndroid }}" alt="QR Endroid">
        </div>

        {{-- Pencarian --}}
        <div class="mb-3">
            <div class="input-group">
                <input type="text" id="search-input" class="form-control"
                    placeholder="Cari surat... (nomor, pengirim, penerima)" value="{{ request('search') }}">
                <button type="button" class="btn btn-secondary" id="clear-search">Clear</button>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div id="data-container">
            @include('transaction.surat.data', ['data' => $data])
        </div>
    </div>

    {{-- Loading indicator --}}
    <div id="loading" style="display: none;" class="text-center">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    
@endsection
