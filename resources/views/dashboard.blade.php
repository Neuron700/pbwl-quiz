@extends('layouts.app')

@section('title', 'Dashboard — LaundryKuy')
@section('breadcrumb', 'Dashboard')

@section('content')
    {{-- Header + aksi cepat --}}
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Selamat datang 👋</h1>
            <p class="text-muted mb-0">{{ auth()->user()->user_namalengkap ?? 'Administrator' }} — ringkasan operasional laundry hari ini.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('transaksi.create') }}" class="btn btn-brand">+ Transaksi</a>
            <a href="{{ route('pelanggan.create') }}" class="btn btn-outline-primary" style="--bs-btn-color:#0f766e;--bs-btn-border-color:#0f766e">+ Pelanggan</a>
        </div>
    </div>

    {{-- Statistik utama --}}
    <div class="row g-3 mb-4">
        @php
            $cards = [
                ['label' => 'Pelanggan', 'value' => $stats['pelanggan'], 'icon' => '👥', 'color' => 'primary'],
                ['label' => 'Layanan', 'value' => $stats['layanan'], 'icon' => '🧺', 'color' => 'success'],
                ['label' => 'Transaksi', 'value' => $stats['transaksi'], 'icon' => '🧾', 'color' => 'dark'],
                ['label' => 'Diproses', 'value' => $stats['proses'], 'icon' => '⏳', 'color' => 'warning'],
                ['label' => 'Selesai', 'value' => $stats['selesai'], 'icon' => '✅', 'color' => 'info'],
                ['label' => 'Omzet', 'value' => 'Rp ' . number_format($stats['omzet'], 0, ',', '.'), 'icon' => '💰', 'color' => 'danger'],
            ];
        @endphp
        @foreach ($cards as $c)
            <div class="col-6 col-lg-4 col-xl-2">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center py-3">
                        <div class="fs-3">{{ $c['icon'] }}</div>
                        <div class="small text-muted">{{ $c['label'] }}</div>
                        <div class="fw-bold h5 mb-0 mt-1">{{ $c['value'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-3">
        {{-- Transaksi terbaru --}}
        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div class="fw-semibold">🧾 Transaksi Terbaru</div>
                    <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-outline-secondary">Lihat semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">ID</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th class="text-end">Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recent as $t)
                                <tr>
                                    <td class="ps-3">#{{ $t->trans_id }}</td>
                                    <td>{{ $t->pelanggan->pel_nama ?? '-' }}</td>
                                    <td>{{ $t->layanan->lay_jenis ?? '-' }}</td>
                                    <td class="text-end">Rp {{ number_format($t->trans_total, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($t->trans_tgl_selesai)
                                            <span class="badge text-bg-success">Selesai</span>
                                        @else
                                            <span class="badge text-bg-warning">Diproses</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Belum ada transaksi — <a href="{{ route('transaksi.create') }}">buat yang pertama</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Ringkasan status --}}
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3 fw-semibold">📈 Progres Pengerjaan</div>
                <div class="card-body">
                    @php
                        $total = max($stats['transaksi'], 1);
                        $persenSelesai = round(($stats['selesai'] / $total) * 100);
                        $persenProses = 100 - $persenSelesai;
                    @endphp
                    <div class="small text-muted mb-1">Selesai — {{ $stats['selesai'] }} transaksi</div>
                    <div class="progress mb-3" style="height: 22px">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $persenSelesai }}%" aria-valuenow="{{ $persenSelesai }}" aria-valuemin="0" aria-valuemax="100">
                            {{ $persenSelesai }}%
                        </div>
                    </div>
                    <div class="small text-muted mb-1">Diproses — {{ $stats['proses'] }} transaksi</div>
                    <div class="progress mb-3" style="height: 22px">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $persenProses }}%" aria-valuenow="{{ $persenProses }}" aria-valuemin="0" aria-valuemax="100">
                            {{ $persenProses }}%
                        </div>
                    </div>
                    <hr>
                    <div class="small text-muted mb-2">Kenapa LaundryKuy?</div>
                    <ul class="small mb-0">
                        <li>Data pelanggan &amp; transaksi tersimpan rapi</li>
                        <li>Total dihitung otomatis dari berat × harga layanan</li>
                        <li>Akses dibatasi halaman login untuk keamanan data</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
