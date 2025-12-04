@extends('layouts.main')
@section('title', 'Gambar')

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Gambar</h5>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addImageModal">
                <i class="bi bi-plus-circle"></i> Tambah Gambar
            </button>
        </div>

        <div class="card-body">
            {{-- tampilkan daftar gambar --}}
            <div class="row">
                @forelse($images as $image)
                    <div class="col-md-3 mb-3">
                        <div class="border p-1 text-center">
                            <img src="{{ asset('storage/' . $image->path) }}" class="img-fluid rounded mb-2">
                            <h6>{{ $image->title }}</h6>

                            {{-- Tombol aksi --}}
                            <div class="d-flex justify-content-center gap-2">
                               
                                <form action="{{ route('images.destroy', $image->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus gambar?')">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Detail --}}
                    <div class="modal fade" id="detailModal{{ $image->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Gambar</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ asset('storage/' . $image->path) }}" class="img-fluid mb-3 rounded">
                                    <p><strong>Judul:</strong> {{ $image->title }}</p>
                                    <p><strong>Deskripsi:</strong> {{ $image->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="text-center">Belum ada gambar.</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Modal Tambah Gambar --}}
    <div class="modal fade" id="addImageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Gambar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Upload Gambar</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>
                        <input type="hidden" value="{{ $id }}" name="room_id">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
