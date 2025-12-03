@extends('layouts.main')
@section('title', 'Tambah Penyewa')
@section('content')
    <div class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Penyewaan Kost</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    {{-- data penyewa --}}
                    {{-- full name --}}
                    <div class="mb-3">
                        <label class="mb-2">Nama Penyewa</label>
                        <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror"
                            value="{{ old('full_name') }}">

                        @error('full_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- email --}}
                    <div class="mb-3">
                        <label class="mb-2">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}">

                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- gender laki-laki or perempuan --}}
                    <div class="mb-3">
                        <label class="mb-2">Jenis Kelamin</label>
                        <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="laki-laki" {{ old('gender') == 'laki-laki' ? 'selected' : '' }}>Laki-laki
                            </option>
                            <option value="perempuan" {{ old('gender') == 'perempuan' ? 'selected' : '' }}>Perempuan
                            </option>
                        </select>
                        @error('gender')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- phone --}}
                    <div class="mb-3">
                        <label class="mb-2">Nomor Telepon</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone') }}">

                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- address texraea --}}
                    <div class="mb-3">
                        <label class="mb-2">Alamat</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address') }}</textarea>

                        @error('address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- pilih room --}}
                    <div class="mb-3">
                        <label class="mb-2">Pilih Kamar</label>
                        <select name="room_id" class="form-control @error('room_id') is-invalid @enderror">
                            <option value="">-- Pilih Kamar --</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                    {{ $room->number }} - Rp{{ number_format($room->tarif, 2, ',', '.') }}</option>
                            @endforeach
                        </select>

                        @error('room_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
