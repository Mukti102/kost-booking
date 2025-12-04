@extends('layouts.main')
@section('title', 'Kamar')

@section('content')
    <section class="section">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Data Kamar</h5>

                <!-- Button Add -->
                <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i>Tambah Kamar
                </a>
            </div>

            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Kamar Tersedia</th>
                            <th>Tarif</th>
                            <th>Jumlah Fasilitas</th>
                            <th>Status Kamar</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($rooms as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->number }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->kamar_tersedia }} Kamar</td>
                                <td>Rp {{ number_format($item->tarif, 0, ',', '.') }}</td>
                                <td>{{ $item->fasilities->count() }} Fasilitas</td>
                                @if ($item->status == 'belum terpakai')
                                    <td><span class="badge bg-success">Tersedia</span></td>
                                @else
                                    <td><span class="badge bg-danger">Penuh</span></td>
                                @endif
                                <td>
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#modalDetail{{ $item->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <!-- Edit -->
                                    <a href="{{ route('rooms.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    
                                    <a href="{{ route('images.index', $item->id) }}" class="btn btn-sm btn-secondary">
                                       <i class="fa-solid fa-image"></i>
                                    </a>



                                    <!-- Delete -->
                                    <form action="{{ route('rooms.destroy', $item->id) }}" method="POST"
                                        class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>

                                <!-- Modal Detail -->
                                <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="detailLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailLabel{{ $item->id }}">
                                                    Detail Kamar {{ $item->number }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p><strong>Kode Kamar:</strong> {{ $item->number }}</p>
                                                        <p><strong>Nama Kamar:</strong> {{ $item->name }}</p>
                                                        <p><strong>Kamar Tersedia:</strong> {{ $item->kamar_tersedia }}</p>
                                                        <p><strong>Tarif:</strong> Rp
                                                            {{ number_format($item->tarif, 0, ',', '.') }}</p>
                                                        <p><strong>Status:</strong>
                                                            @if ($item->status == 'belum terpakai')
                                                                <span class="badge bg-warning">Belum Terpakai</span>
                                                            @else
                                                                <span class="badge bg-success">Terpakai</span>
                                                            @endif
                                                        </p>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <p><strong>Deskripsi:</strong></p>
                                                        <p>{{ $item->description ?? '-' }}</p>
                                                    </div>
                                                </div>

                                                <hr>

                                                <h6>Fasilitas Kamar:</h6>

                                                @if ($item->fasilities->count() > 0)
                                                    <ul>
                                                        @foreach ($item->fasilities as $f)
                                                            <li>{{ $f->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p>Tidak ada fasilitas.</p>
                                                @endif

                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </section>

@endsection
