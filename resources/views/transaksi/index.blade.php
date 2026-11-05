@extends('layouts.app')

@section('title', 'Transaksi — LaundryKuy')
@section('breadcrumb', 'Transaksi')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <h1 class="h4 fw-bold mb-0">🧾 Transaksi</h1>
            <p class="text-muted small mb-0">Catatan penerimaan cucian; total dihitung otomatis.</p>
        </div>
        <a href="{{ route('transaksi.create') }}" class="btn btn-brand">+ Transaksi Baru</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between gap-2 mb-3">
                <div class="btn-group" role="group" aria-label="Filter status">
                    <a class="btn btn-outline-secondary {{ !request('status') ? 'active' : '' }}" href="{{ route('transaksi.index', array_filter(['cari' => request('cari')])) }}">Semua</a>
                    <a class="btn btn-outline-warning {{ request('status') === 'proses' ? 'active' : '' }}" href="{{ route('transaksi.index', array_filter(['cari' => request('cari'), 'status' => 'proses'])) }}">Diproses</a>
                    <a class="btn btn-outline-success {{ request('status') === 'selesai' ? 'active' : '' }}" href="{{ route('transaksi.index', array_filter(['cari' => request('cari'), 'status' => 'selesai'])) }}">Selesai</a>
                </div>
                <form method="GET" action="{{ route('transaksi.index') }}" class="d-flex gap-2">
                    @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <input type="search" name="cari" value="{{ request('cari') }}" class="form-control" placeholder="Cari pelanggan / layanan / ID…" aria-label="Cari transaksi" style="min-width: 260px">
                    <button type="submit" class="btn btn-outline-secondary">Cari</button>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">ID</th>
                            <th>Masuk → Selesai</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th class="text-center">Berat</th>
                            <th class="text-end">Total</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi as $t)
                            <tr>
                                <td class="ps-3 fw-semibold">#{{ $t->trans_id }}</td>
                                <td class="small">{{ $t->trans_tgl_masuk->format('d/m/Y') }} → {{ $t->trans_tgl_selesai ? $t->trans_tgl_selesai->format('d/m/Y') : 'proses' }}</td>
                                <td>{{ $t->pelanggan->pel_nama ?? '-' }}</td>
                                <td>{{ $t->layanan->lay_jenis ?? '-' }}</td>
                                <td class="text-center">{{ $t->trans_berat }} kg</td>
                                <td class="text-end">Rp {{ number_format($t->trans_total, 0, ',', '.') }}</td>
                                <td>
                                    @if ($t->trans_tgl_selesai)
                                        <span class="badge text-bg-success">Selesai</span>
                                    @else
                                        <span class="badge text-bg-warning">Diproses</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('transaksi.edit', $t) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                                        <form method="POST" action="{{ route('transaksi.destroy', $t) }}" onsubmit="return confirm('Yakin hapus transaksi #{{ $t->trans_id }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">Belum ada transaksi yang cocok.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">{{ $transaksi->links() }}</div>
        </div>
    </div>
@endsection