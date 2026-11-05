@extends('layouts.app')

@section('title', 'Ubah Transaksi — LaundryKuy')
@section('breadcrumb', 'Transaksi › Ubah')

@section('content')
    <div class="card shadow-sm" style="max-width: 860px">
        <div class="card-header bg-white fw-semibold">Ubah Transaksi</div>
        <div class="card-body">
<form method="POST" action="{{ route('transaksi.update', $transaksi) }}">
    @csrf
    @method('PUT')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif
    <div class="row g-3">
        <div class="col-md-6">
            <label for="trans_id_pelanggan" class="form-label">Pelanggan <span style="color:#dc2626">*</span></label>
            <select name="trans_id_pelanggan" id="trans_id_pelanggan" class="form-select" required>
                <option value="">— pilih pelanggan —</option>
                @foreach ($pelanggan as $p)
                    <option value="{{ $p->pel_id }}" @selected(old('trans_id_pelanggan', $transaksi->trans_id_pelanggan ?? null) == $p->pel_id)>
                        {{ $p->pel_nama }} ({{ $p->pel_hp }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="trans_id_layanan" class="form-label">Layanan <span style="color:#dc2626">*</span></label>
            <select name="trans_id_layanan" id="trans_id_layanan" class="form-select lay-select" data-harga="" required>
                <option value="">— pilih layanan —</option>
                @foreach ($layanan as $l)
                    <option value="{{ $l->lay_id }}" data-harga="{{ $l->lay_harga }}" @selected(old('trans_id_layanan', $transaksi->trans_id_layanan ?? null) == $l->lay_id)>
                        {{ $l->lay_jenis }} — Rp {{ number_format($l->lay_harga, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="trans_tgl_masuk" class="form-label">Tanggal Masuk <span style="color:#dc2626">*</span></label>
            <input type="date" name="trans_tgl_masuk" id="trans_tgl_masuk" class="form-control" value="{{ old('trans_tgl_masuk', isset($transaksi) ? $transaksi->trans_tgl_masuk->format('Y-m-d') : date('Y-m-d')) }}" required>
        </div>
        <div class="col-md-4">
            <label for="trans_tgl_selesai" class="form-label">Tanggal Selesai <span class="text-muted">(kosong = masih diproses)</span></label>
            <input type="date" name="trans_tgl_selesai" id="trans_tgl_selesai" class="form-control" value="{{ old('trans_tgl_selesai', isset($transaksi) && $transaksi->trans_tgl_selesai ? $transaksi->trans_tgl_selesai->format('Y-m-d') : '') }}">
        </div>
        <div class="col-md-4">
            <label for="trans_berat" class="form-label">Berat / Qty (kg) <span style="color:#dc2626">*</span></label>
            <input type="number" name="trans_berat" id="trans_berat" class="form-control berat-input" min="1" step="1" value="{{ old('trans_berat', $transaksi->trans_berat ?? 1) }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Estimasi Total</label>
            <div class="form-control fw-semibold" id="estimasiTotal" style="background:#f9fafb">Rp 0</div>
            <div class="form-text">Dihitung otomatis: berat × harga layanan (per kg).</div>
        </div>
    </div>
    <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-brand">Perbarui</button>
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</form>

<script>
    function hitungTotal() {
        const select = document.querySelector('.lay-select');
        const opt = select.selectedOptions[0];
        const harga = opt ? Number(opt.dataset.harga || 0) : 0;
        const berat = Number(document.querySelector('.berat-input').value || 0);
        document.getElementById('estimasiTotal').textContent = 'Rp ' + (harga * berat).toLocaleString('id-ID');
    }
    document.querySelector('.lay-select').addEventListener('change', hitungTotal);
    document.querySelector('.berat-input').addEventListener('input', hitungTotal);
    hitungTotal();
</script>
        </div>
    </div>
@endsection