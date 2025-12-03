@extends('layouts.main')
@section('title', 'Metode Pembayaran')

@section('content')
    <section class="section">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Data Pembayaran</h5>

                <!-- Button Add -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
                    <i class="bi bi-plus"></i> Tambah Pembayaran
                </button>
            </div>

            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>No Rekening</th>
                            <th>Logo</th>
                            <th>QRIS</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($typePayments as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->no_rekening }}</td>
                                <td>
                                    @if ($item->logo)
                                        <img src="{{ asset('storage/' . $item->logo) }}" width="60">
                                    @else
                                        <span class="text-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->qris_url)
                                        <img src="{{ asset('storage/' . $item->qris_url) }}" width="60">
                                    @else
                                        <span class="text-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- View -->
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#modalDetail{{ $item->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <!-- Edit -->
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $item->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <!-- Delete -->
                                    <form action="{{ route('type-payments.destroy', $item->id) }}" method="POST"
                                        class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Modal Detail --}}
                            <div class="modal fade" id="modalDetail{{ $item->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5>Detail Pembayaran - {{ $item->name }}</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <p><strong>Nama:</strong> {{ $item->name }}</p>
                                            <p><strong>No Rekening:</strong> {{ $item->no_rekening }}</p>
                                            <p><strong>Deskripsi:</strong> {{ $item->description ?? '-' }}</p>
                                            <p><strong>Logo:</strong></p>
                                            @if ($item->logo)
                                                <img src="{{ asset('storage/' . $item->logo) }}" width="120">
                                            @else
                                                <p class="text-secondary">Tidak ada logo</p>
                                            @endif
                                            <p><strong>QRIS:</strong></p>
                                            @if ($item->qris_url)
                                                <img src="{{ asset('storage/' . $item->qris_url) }}" width="120">
                                            @else
                                                <p class="text-secondary">Tidak ada QRIS</p>
                                            @endif
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- Modal Edit --}}
                            <div class="modal fade" id="modalEdit{{ $item->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('type-payments.update', $item->id) }}" method="POST"
                                            enctype="multipart/form-data" class="modal-content">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-header">
                                                <h5>Edit Pembayaran - {{ $item->name }}</h5>
                                                <button class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">

                                                <div class="mb-3">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" name="name"
                                                        value="{{ $item->name }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label>No Rekening</label>
                                                    <input type="text" class="form-control" name="no_rekening"
                                                        value="{{ $item->no_rekening }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label>Deskripsi</label>
                                                    <textarea class="form-control" name="description">{{ $item->description }}</textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Logo</label>
                                                    <input type="file" class="form-control" name="logo">
                                                </div>

                                                <div class="mb-3">
                                                    <label>QRIS</label>
                                                    <input type="file" class="form-control" name="qris_url">
                                                </div>

                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button class="btn btn-primary">Simpan</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>

    {{-- Modal Add --}}
    <div class="modal fade" id="modalAdd">
        <div class="modal-dialog">
            <form action="{{ route('type-payments.store') }}" method="POST" enctype="multipart/form-data"
                class="modal-content">
                @csrf

                <div class="modal-header">
                    <h5>Tambah Pembayaran</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Nama Pembayaran</label>
                        <input type="text" class="form-control" name="name">
                    </div>

                    <div class="mb-3">
                        <label>No Rekening</label>
                        <input type="text" class="form-control" name="no_rekening">
                    </div>

                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Logo</label>
                        <input type="file" class="form-control" name="logo">
                    </div>

                    <div class="mb-3">
                        <label>QRIS</label>
                        <input type="file" class="form-control" name="qris_url">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@endsection
