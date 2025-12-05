@extends('layouts.main')
@section('title', 'Tambah Kamar')

@section('content')
    <div class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Kamar</h4>
            </div>

            <div class="card-body">

                <form action="{{ route('rooms.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            {{-- Number --}}
                            <div class=" mb-3">
                                <label class="mb-2">Nomor Kamar</label>
                                <input type="text" name="number"
                                    class="form-control @error('number') is-invalid @enderror" value="{{ $numberUnique }}"
                                    readonly>

                                @error('number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            {{-- nama --}}
                            <div class=" mb-3">
                                <label class="mb-2">Nama</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror">

                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            {{-- kamar tersedia --}}
                            <div class=" mb-3">
                                <label class="mb-2">Kamar Tersedia</label>
                                <input type="number" name="kamar_tersedia"
                                    class="form-control @error('kamar_tersedia') is-invalid @enderror">

                                @error('kamar_tersedia')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>



                            {{-- Tarif --}}
                            <div class=" mb-3">
                                <label class="mb-2">Tarif</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                    <input name="tarif" type="number" class="form-control" placeholder="Tarif"
                                        aria-label="Username" aria-describedby="basic-addon1">
                                </div>

                                @error('tarif')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            {{-- duration --}}
                            <div class=" mb-3">
                                <label class="mb-2">Durasi</label>
                                <select name="duration" class="form-control @error('duration') is-invalid @enderror">
                                    <option value="">-- Pilih Durasi --</option>
                                    <option value="bulan" {{ old('duration') == 'bulan' ? 'selected' : '' }}>
                                        Perbulan</option>
                                    <option value="tahun" {{ old('duration') == 'tahun' ? 'selected' : '' }}>Rertahun
                                    </option>
                                </select>

                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class=" mb-3">
                                <label class="mb-2">Status</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="belum terpakai"
                                        {{ old('status') == 'belum terpakai' ? 'selected' : '' }}>
                                        Belum Terpakai</option>
                                    <option value="terpakai" {{ old('status') == 'terpakai' ? 'selected' : '' }}>Terpakai
                                    </option>
                                </select>

                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div class="2 mb-3">
                                <label class="mb-2">Deskripsi</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                                    placeholder="Masukkan deskripsi kamar (opsional)">{{ old('description') }}</textarea>

                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-7">
                            {{-- Fasilitas --}}
                            <label class="mb-2">Fasilitas Kamar</label>
                            <div class="row">
                                @foreach ($fasilities as $item)
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="fasilities[]"
                                                value="{{ $item->id }}" id="fasility{{ $item->id }}">
                                            <label class="form-check-label"
                                                for="fasility{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
