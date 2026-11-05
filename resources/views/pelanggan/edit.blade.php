@extends('layouts.app')

@section('title', 'Ubah Pelanggan — LaundryKuy')
@section('breadcrumb', 'Pelanggan › Ubah')

@section('content')
    <div class="card shadow-sm" style="max-width: 640px">
        <div class="card-header bg-white fw-semibold">Ubah Pelanggan</div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif
            <form method="POST" action="{{ route('pelanggan.update', $pelanggan) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="pel_nama" class="form-label">Nama <span style="color:#dc2626">*</span></label>
                    <input type="text" name="pel_nama" id="pel_nama" class="form-control" value="{{ old('pel_nama', $pelanggan->pel_nama) }}" required maxlength="100">
                </div>
                <div class="mb-3">
                    <label for="pel_alamat" class="form-label">Alamat</label>
                    <textarea name="pel_alamat" id="pel_alamat" class="form-control" rows="3">{{ old('pel_alamat', $pelanggan->pel_alamat) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="pel_hp" class="form-label">Nomor HP <span style="color:#dc2626">*</span></label>
                    <input type="text" name="pel_hp" id="pel_hp" class="form-control" value="{{ old('pel_hp', $pelanggan->pel_hp) }}" required maxlength="30" inputmode="tel">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-brand">Perbarui</button>
                    <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection