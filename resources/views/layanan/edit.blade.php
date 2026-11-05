@extends('layouts.app')

@section('title', 'Ubah Layanan — LaundryKuy')
@section('breadcrumb', 'Layanan › Ubah')

@section('content')
    <div class="card shadow-sm" style="max-width: 540px">
        <div class="card-header bg-white fw-semibold">Ubah Layanan</div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif
            <form method="POST" action="{{ route('layanan.update', $layanan) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="lay_jenis" class="form-label">Jenis Layanan</label>
                    <input type="text" name="lay_jenis" id="lay_jenis" class="form-control" value="{{ old('lay_jenis', $layanan->lay_jenis) }}" required maxlength="100">
                </div>
                <div class="mb-3">
                    <label for="lay_harga" class="form-label">Harga (Rp)</label>
                    <input type="number" name="lay_harga" id="lay_harga" class="form-control" value="{{ old('lay_harga', $layanan->lay_harga) }}" min="0" step="1000" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-brand">Perbarui</button>
                    <a href="{{ route('layanan.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection