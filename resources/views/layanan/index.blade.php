@extends('layouts.app')

@section('title', 'Layanan — LaundryKuy')
@section('breadcrumb', 'Layanan')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <h1 class="h4 fw-bold mb-0">🧺 Daftar Layanan</h1>
            <p class="text-muted small mb-0">Kelola jenis layanan dan harganya (per kg / satuan).</p>
        </div>
        <a href="{{ route('layanan.create') }}" class="btn btn-brand">+ Tambah Layanan</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('layanan.index') }}" class="row g-2 mb-3">
                <div class="col-sm-8 col-md-6">
                    <input type="search" name="cari" value="{{ request('cari') }}" class="form-control" placeholder="Cari jenis layanan…" aria-label="Cari layanan">
                </div>
                <div class="col-sm-4 col-md-2">
                    <button type="submit" class="btn btn-outline-secondary w-100">Cari</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Jenis Layanan</th>
                            <th class="text-end">Harga (Rp)</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($layanan as $i => $l)
                            <tr>
                                <td class="ps-3">{{ $layanan->firstItem() + $i }}</td>
                                <td class="fw-semibold">{{ $l->lay_jenis }}</td>
                                <td class="text-end">Rp {{ number_format($l->lay_harga, 0, ',', '.') }}</td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('layanan.edit', $l) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                                        <form method="POST" action="{{ route('layanan.destroy', $l) }}" onsubmit="return confirm('Yakin hapus layanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada layanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">{{ $layanan->links() }}</div>
        </div>
    </div>
@endsection