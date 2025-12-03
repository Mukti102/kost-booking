@extends('layouts.main')
@section('title', 'Edit Kamar')

@section('content')
    <div class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Kamar</h4>
            </div>

            <div class="card-body">

                <form action="{{ route('rooms.update', $room->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-5">

                            {{-- Number --}}
                            <div class="mb-3">
                                <label class="mb-2">Nomor Kamar</label>
                                <input type="text" name="number"
                                    class="form-control @error('number') is-invalid @enderror"
                                    value="{{ old('number', $room->number) }}">

                                @error('number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>



                            {{-- nama --}}
                            <div class=" mb-3">
                                <label class="mb-2">Nama</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $room->name) }}">

                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            {{-- kamar tersedia --}}
                            <div class=" mb-3">
                                <label class="mb-2">Kamar Tersedia</label>
                                <input type="number" name="kamar_tersedia"
                                    class="form-control @error('kamar_tersedia') is-invalid @enderror" value="{{ old('kamar_tersedia', $room->kamar_tersedia) }}">

                                @error('kamar_tersedia')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Tarif --}}
                            <div class="mb-3">
                                <label class="mb-2">Tarif</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Rp</span>
                                    <input name="tarif" type="number" class="form-control" placeholder="Tarif Perbulan"
                                        value="{{ old('tarif', $room->tarif) }}">
                                </div>

                                @error('tarif')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="mb-3">
                                <label class="mb-2">Status</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="">-- Pilih Status --</option>

                                    <option value="belum terpakai"
                                        {{ old('status', $room->status) == 'belum terpakai' ? 'selected' : '' }}>
                                        Belum Terpakai
                                    </option>

                                    <option value="terpakai"
                                        {{ old('status', $room->status) == 'terpakai' ? 'selected' : '' }}>
                                        Terpakai
                                    </option>
                                </select>

                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-3">
                                <label class="mb-2">Deskripsi</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                                    placeholder="Masukkan deskripsi kamar (opsional)">{{ old('description', $room->description) }}</textarea>

                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-7">
                            {{-- Fasilitas --}}
                            <label class="mb-2">Fasilitas Kamar</label>
                            <div class="row">

                                @php
                                    $roomFasilities = $room->fasilities->pluck('id')->toArray();
                                @endphp

                                @foreach ($fasilities as $item)
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="fasilities[]"
                                                value="{{ $item->id }}" id="fasility{{ $item->id }}"
                                                {{-- Centang jika fasilitas dimiliki kamar --}}
                                                {{ in_array($item->id, old('fasilities', $roomFasilities)) ? 'checked' : '' }}>

                                            <label class="form-check-label" for="fasility{{ $item->id }}">
                                                {{ $item->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            @error('fasilities')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
