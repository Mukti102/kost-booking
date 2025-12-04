@extends('layouts.main')
@section('title', 'Booking')

@section('content')
    <section class="section">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Data Penyewaan Kost</h5>

                <!-- Button Add -->
                <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Tambah Penyewaan
                </a>
            </div>

            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Booking</th>
                            <th>Type Kamar</th>
                            <th>Nama Penyewa</th>
                            <th>Tarif</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->room->name }}</td>
                                <td>{{ $item->tenant->full_name }}</td>
                                <td>Rp {{ number_format($item->room->tarif, 0, ',', '.') }}</td>

                                <td>
                                    @if ($item->status == 'diterima')
                                        <span class=" badge bg-success">Diterima</span>
                                    @elseif($item->status == 'ditolak')
                                        <span class=" badge bg-danger">Ditolak</span>
                                    @else
                                        <span class=" badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('bookings.show', $item->id) }}" class="btn btn-sm btn-secondary">
                                        <i class="bi bi-receipt"></i> Cek
                                    </a>

                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#modalPembayaran{{ $item->id }}">
                                        <i class="bi bi-cash"></i> Bayar
                                    </button>

                                    <!-- Detail -->
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#modalDetail{{ $item->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <!-- Modal Detail -->
                                    <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="modalDetailLabel{{ $item->id }}" aria-hidden="true">

                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalDetailLabel{{ $item->id }}">
                                                        Detail Penyewaan #{{ $item->code }}
                                                    </h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th style="width: 40%">Nama Penyewa</th>
                                                            <td>{{ $item->tenant->full_name }}</td>
                                                        </tr>

                                                        <tr>
                                                            <th>Email</th>
                                                            <td>{{ $item->tenant->email }}</td>
                                                        </tr>

                                                        <tr>
                                                            <th>Jenis Kelamin</th>
                                                            <td>{{ ucfirst($item->tenant->gender) }}</td>
                                                        </tr>

                                                        <tr>
                                                            <th>No. Telepon</th>
                                                            <td>{{ $item->tenant->phone }}</td>
                                                        </tr>

                                                        <tr>
                                                            <th>Alamat</th>
                                                            <td>{{ $item->tenant->address }}</td>
                                                        </tr>

                                                        <tr>
                                                            <th>Nomor Kamar</th>
                                                            <td>{{ $item->room->number }}</td>
                                                        </tr>

                                                        <tr>
                                                            <th>Tarif Kamar</th>
                                                            <td>Rp {{ number_format($item->room->tarif, 0, ',', '.') }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th>Status Penyewaan</th>
                                                            <td>
                                                                <span
                                                                    class="badge bg-{{ $item->status == 'pending' ? 'secondary' : ($item->status == 'diterima' ? 'success' : 'danger') }}">
                                                                    {{ ucfirst($item->status) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    <a href="{{ route('bookings.edit', $item->id) }}"
                                                        class="btn btn-primary">
                                                        <i class="bi bi-pencil"></i> Edit Booking
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit -->
                                    <a href="{{ route('bookings.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('bookings.destroy', $item->id) }}" method="POST"
                                        class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <div class="modal fade" id="modalPembayaran{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Pembayaran Kost {{ $item->tenant->full_name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form action="{{ route('payments.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="booking_id" value="{{ $item->id }}">

                                            <div class="modal-body">

                                                {{-- pilih jenis pembayaran --}}
                                                <div class="mb-3">
                                                    <label class="form-label">Metode Pembayaran</label>
                                                    <select name="type_payment_id" class="form-select" required>
                                                        <option value="">-- Pilih --</option>
                                                        @foreach ($typePayments as $type)
                                                            <option value="{{ $type->id }}">{{ $type->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                {{-- amount --}}
                                                <div class="mb-3">
                                                    <label class="form-label">Nominal</label>
                                                    <input type="number" readonly value="{{ $item->room->tarif / 2 }}"
                                                        step="1000" class="form-control" name="amount" required>
                                                </div>

                                                {{-- bukti transfer --}}
                                                <div class="mb-3">
                                                    <label class="form-label">Upload Bukti Pembayaran (opsional)</label>
                                                    <input type="file" class="form-control" name="payment_proof"
                                                        accept="image/*">
                                                </div>

                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="bi bi-send"></i> Proses Pembayaran
                                                </button>
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

@endsection
