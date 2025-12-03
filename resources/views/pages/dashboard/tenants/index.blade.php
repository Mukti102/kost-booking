@extends('layouts.main')
@section('title', 'Tenant')

@section('content')
<section class="section">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Data Tenant</h5>

            <!-- Button Add -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
                <i class="bi bi-plus"></i> Tambah Tenant
            </button>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tenants as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->full_name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ ucfirst($item->gender) }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>
                            <!-- Detail -->
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
                            <form action="{{ route('tenants.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">
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
                                    <h5>Detail Tenant</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <p><strong>Nama:</strong> {{ $item->full_name }}</p>
                                    <p><strong>Email:</strong> {{ $item->email }}</p>
                                    <p><strong>Gender:</strong> {{ ucfirst($item->gender) }}</p>
                                    <p><strong>Telepon:</strong> {{ $item->phone }}</p>
                                    <p><strong>Alamat:</strong> {{ $item->address }}</p>
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
                            <form action="{{ route('tenants.update', $item->id) }}" method="POST" class="modal-content">
                                @csrf
                                @method('PUT')

                                <div class="modal-header">
                                    <h5>Edit Tenant</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label>Nama Lengkap</label>
                                        <input type="text" class="form-control" name="full_name"
                                            value="{{ $item->full_name }}">
                                    </div>

                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ $item->email }}">
                                    </div>

                                    <div class="mb-3">
                                        <label>Gender</label>
                                        <select class="form-control" name="gender">
                                            <option value="male" {{ $item->gender=='male' ? 'selected':'' }}>Laki-laki</option>
                                            <option value="female" {{ $item->gender=='female' ? 'selected':'' }}>Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ $item->phone }}">
                                    </div>

                                    <div class="mb-3">
                                        <label>Alamat</label>
                                        <textarea class="form-control" name="address">{{ $item->address }}</textarea>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button class="btn btn-primary">Simpan</button>
                                </div>

                            </form>
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
        <form action="{{ route('tenants.store') }}" method="POST" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5>Tambah Tenant</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="full_name" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Gender</label>
                    <select name="gender" class="form-control">
                        <option value="male">Laki-laki</option>
                        <option value="female">Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Telepon</label>
                    <input type="text" name="phone" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="address" class="form-control"></textarea>
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
