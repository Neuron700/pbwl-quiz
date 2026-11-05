@extends('layouts.app')

@section('title', 'Data Pelanggan — LaundryKuy')
@section('breadcrumb', 'Pelanggan')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <h1 class="h4 fw-bold mb-0">👥 Data Pelanggan</h1>
            <p class="text-muted small mb-0">Kelola informasi pelanggan laundry Anda.</p>
        </div>
        <a href="{{ route('pelanggan.create') }}" class="btn btn-brand">+ Tambah Pelanggan</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('pelanggan.index') }}" class="row g-2 mb-3">
                <div class="col-sm-8 col-md-6">
                    <input type="search" name="cari" value="{{ request('cari') }}" class="form-control" placeholder="Cari nama / HP / alamat…" aria-label="Cari pelanggan">
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
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No. HP</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pelanggan as $i => $p)
                            <tr>
                                <td class="ps-3">{{ $pelanggan->firstItem() + $i }}</td>
                                <td class="fw-semibold">{{ $p->pel_nama }}</td>
                                <td class="text-muted" style="max-width: 320px">{{ $p->pel_alamat ?? '-' }}</td>
                                <td><code>{{ $p->pel_hp }}</code></td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('pelanggan.edit', $p) }}" class="btn btn-outline-primary btn-sm" title="Ubah">Edit</a>
                                        <form method="POST" action="{{ route('pelanggan.destroy', $p) }}" onsubmit="return confirm('Yakin hapus pelanggan {{ $p->pel_nama }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Tidak ada data pelanggan{{ request('cari') ? ' untuk kata kunci tersebut' : '' }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">{{ $pelanggan->links() }}</div>
        </div>
    </div>
@endsection