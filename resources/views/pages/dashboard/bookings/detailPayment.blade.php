@extends('layouts.main')

@section('title', 'Detail Pembayaran Penyewaan')

@section('content')
    <div class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Detail Pembayaran Kost #{{ $payment->booking->code }}</h4>

                @if ($payment->status == 'pending')
                    <div>
                        <form action="{{ route('payments.confirm', $payment->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="bi bi-check-circle"></i> Konfirmasi
                            </button>
                        </form>

                        <form action="{{ route('payments.reject', $payment->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-x-circle"></i> Tolak
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Kode Booking</th>
                        <td>{{ $payment->booking->code }}</td>
                    </tr>

                    <tr>
                        <th>Nama Penyewa</th>
                        <td>{{ $payment->booking->tenant->full_name }}</td>
                    </tr>

                    <tr>
                        <th>Jenis Pembayaran</th>
                        <td>{{ $payment->typePayment->name }}</td>
                    </tr>

                    <tr>
                        <th>Jumlah</th>
                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>
                            <span
                                class="badge bg-{{ $payment->status == 'completed' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Bukti Pembayaran</th>
                        <td>
                            @if ($payment->payment_proof)
                                <img src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Bukti Pembayaran"
                                    width="120" class="img-thumbnail" data-bs-toggle="modal"
                                    data-bs-target="#modalProof">
                            @else
                                <span class="text-muted">Belum diunggah</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal zoom bukti pembayaran --}}
    @if ($payment->payment_proof)
        <div class="modal fade" id="modalProof" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <img src="{{ asset('storage/' . $payment->payment_proof) }}" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
