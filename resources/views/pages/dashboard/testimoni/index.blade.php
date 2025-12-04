@extends('layouts.main')
@section('title', 'Testimoni')

@section('content')

    <div class="card shadow">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-0">Daftar Testimoni</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
                + Tambah Testimoni
            </button>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Rate</th>
                        <th>Comment</th>
                        <th width="155px">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($tetstimonis as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>

                            <td>
                                @if ($item->photo)
                                    <img src="{{ asset('storage/' . $item->photo) }}" width="50" class="rounded">
                                @else
                                    <img src="https://placehold.co/50x50" width="50" class="rounded">
                                @endif
                            </td>

                            <td>{{ $item->name }}</td>
                            <td>{{ $item->jabatan }}</td>
                            <td>{{ $item->rate }}</td>
                            <td>{{ $item->comment }}</td>

                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#modalEdit{{ $item->id }}">
                                    Edit
                                </button>

                                <form action="{{ route('testimoni.destroy', $item->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>

                        </tr>

                        {{-- Modal Edit --}}
                        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form  action="{{ route('testimoni.update', $item->id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
    
                                        <div class="modal-header">
                                            <h5>Edit Testimoni</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
    
                                        <div class="modal-body">
    
                                            <div class="mb-2">
                                                <label>Nama</label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ $item->name }}">
                                            </div>
    
                                            <div class="mb-2">
                                                <label>Jabatan</label>
                                                <input type="text" name="jabatan" class="form-control"
                                                    value="{{ $item->jabatan }}">
                                            </div>
    
                                            <div class="mb-2">
                                                <label>Rate</label>
                                                <input type="number" max="5" min="1" name="rate"
                                                    class="form-control" value="{{ $item->rate }}">
                                            </div>
    
                                            <div class="mb-2">
                                                <label>Comment</label>
                                                <textarea name="comment" class="form-control">{{ $item->comment }}</textarea>
                                            </div>
    
                                            <div class="mb-2">
                                                <label>Foto (opsional)</label><br>
                                                <input type="file" name="photo" class="form-control">
                                            </div>
    
                                            @if ($item->photo)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $item->photo) }}" width="90"
                                                        class="rounded">
                                                </div>
                                            @endif
    
                                        </div>
    
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button class="btn btn-primary">Update</button>
                                        </div>
    
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada testimoni</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>


    {{-- Modal Add --}}
    <div class="modal fade" id="modalAdd" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('testimoni.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5>Tambah Testimoni</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-2">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Jabatan</label>
                        <input type="text" name="jabatan" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Rate</label>
                        <input type="number" max="5" min="1" name="rate" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Comment</label>
                        <textarea name="comment" class="form-control"></textarea>
                    </div>

                    <div class="mb-2">
                        <label>Foto (opsional)</label><br>
                        <input type="file" name="photo" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>

@endsection
