@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <section class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-12">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon purple mb-2">
                                        <i class="fa-solid fa-wifi"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">
                                        Data Fasilitas
                                    </h6>
                                    <h6 class="font-extrabold mb-0">{{ $facilities->count() }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-12">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon blue mb-2">
                                      <i class="fa-solid fa-bed"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Data Kamar</h6>
                                    <h6 class="font-extrabold mb-0">{{ $rooms->count() }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-12">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon green mb-2">
                                        <i class="fa-solid fa-users"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Penghuni</h6>
                                    <h6 class="font-extrabold mb-0">{{ $bookings->where('status', 'diterima')->count() }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-12">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon red mb-2">
                                      <i class="fa-solid fa-cash-register"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Data Booking</h6>
                                    <h6 class="font-extrabold mb-0">{{$bookings->count()}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-12">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon red mb-2">
                                       <i class="fa-solid fa-credit-card"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold"> Methode Pembayaran</h6>
                                    <h6 class="font-extrabold mb-0">{{$typePayments->count()}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar Booking Penyewa Yg Belum DI Konfirmasi</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Penyewaan</th>
                                            <th>Nama Penyewa</th>
                                            <th>Tarif</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bookings->where('status', 'pending') as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->code }}</td>
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
                                                    <a href="{{ route('bookings.show', $item->id) }}"
                                                       style="width: max-content" class="btn btn-sm btn-secondary d-flex items-center">
                                                        <i class="bi bi-receipt me-1"></i> Cek
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
