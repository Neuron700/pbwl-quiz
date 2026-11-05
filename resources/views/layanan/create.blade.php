@extends('layouts.app')

@section('title', 'Tambah Layanan — LaundryKuy')
@section('breadcrumb', 'Layanan › Tambah')

@section('content')
    <div class="card shadow-sm" style="max-width: 540px">
        <div class="card-header bg-white fw-semibold">Tambah Layanan</div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif
            <form method="POST" action="{{ route('layanan.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="lay_jenis" class="form-label">Jenis Layanan <span style="color:#dc2626">*</span></label>
                    <input type="text" name="lay_jenis" id="lay_jenis" class="form-control" value="{{ old('lay_jenis') }}" placeholder="Mis. Cuci + Setrika" required maxlength="100">
                </div>
                <div class="mb-3">
                    <label for="lay_harga" class="form-label">Harga (Rp)</label>
                    <input type="number" name="lay_harga" id="lay_harga" class="form-control" value="{{ old('lay_harga') }}" min="0" step="1000" placeholder="0" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-brand">Simpan</button>
                    <a href="{{ route('layanan.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection