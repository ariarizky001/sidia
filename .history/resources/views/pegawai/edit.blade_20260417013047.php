@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Edit Pegawai</h3>
                </div>
                <form action="{{ route('pegawai.update', $pegawai->id ?? 1) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Pegawai</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $pegawai->name ?? '') }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <input type="text" class="form-control @error('nip') is-invalid @enderror"
                                   id="nip" name="nip" value="{{ old('nip', $pegawai->nip ?? '') }}" required>
                            @error('nip')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $pegawai->email ?? '') }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Nomor Telepon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone" value="{{ old('phone', $pegawai->phone ?? '') }}">
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="department">Departemen</label>
                            <input type="text" class="form-control @error('department') is-invalid @enderror"
                                   id="department" name="department" value="{{ old('department', $pegawai->department ?? '') }}" required>
                            @error('department')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="position">Posisi/Jabatan</label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror"
                                   id="position" name="position" value="{{ old('position', $pegawai->position ?? '') }}" required>
                            @error('position')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="start_date">Tanggal Bergabung</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                   id="start_date" name="start_date" value="{{ old('start_date', $pegawai->start_date ?? '') }}" required>
                            @error('start_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
