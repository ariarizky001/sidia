@extends('layouts.admin')

@section('title', 'Tambah Unit Kerja')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Unit Kerja</h1>
        </div>
        <div class="col-sm-6">
            <a href="{{ route('unit-kerja.index') }}" class="btn btn-secondary float-right">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Unit Kerja</h3>
                </div>
                <form action="{{ route('unit-kerja.store') }}" method="POST" class="form-horizontal">
                    @csrf
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h4 class="alert-heading">
                                    <i class="fas fa-exclamation-circle"></i> Validation Error
                                </h4>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="form-group row">
                            <label for="level" class="col-sm-3 col-form-label">Level <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="level" id="level" class="form-control @error('level') is-invalid @enderror" required onchange="updateParentOptions()">
                                    <option value="">-- Pilih Level --</option>
                                    <option value="1" @selected(old('level') == 1)>1 - Induk (Dinas)</option>
                                    <option value="2" @selected(old('level') == 2)>2 - Korwil/Bidang</option>
                                    <option value="3" @selected(old('level') == 3)>3 - Sekolah/Seksi</option>
                                </select>
                                @error('level')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="parent_id" class="col-sm-3 col-form-label">Parent Unit Kerja</label>
                            <div class="col-sm-9">
                                <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                                    <option value="">-- Pilih Parent (untuk Level 2 & 3) --</option>
                                </select>
                                @error('parent_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 col-form-label">Nama Unit Kerja <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="nama" id="nama"
                                       class="form-control @error('nama') is-invalid @enderror"
                                       value="{{ old('nama') }}"
                                       placeholder="Contoh: Dinas Pendidikan"
                                       required>
                                @error('nama')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jenis_unit_id" class="col-sm-3 col-form-label">Jenis Unit</label>
                            <div class="col-sm-9">
                                <select name="jenis_unit_id" id="jenis_unit_id" class="form-control @error('jenis_unit_id') is-invalid @enderror">
                                    <option value="">-- Pilih Jenis Unit (otomatis saat import) --</option>
                                    @foreach ($jenisUnits as $jenis)
                                        <option value="{{ $jenis->id }}" @selected(old('jenis_unit_id') == $jenis->id)>
                                            {{ $jenis->nama }} {{ $jenis->is_sekolah ? '(Sekolah)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Pilih kategori unit kerja</small>
                                @error('jenis_unit_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('unit-kerja.index') }}" class="btn btn-default">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateParentOptions() {
            const level = document.getElementById('level').value;
            const parentSelect = document.getElementById('parent_id');

            if (level === '1') {
                parentSelect.innerHTML = '<option value="">-- Tidak ada Parent (Level 1) --</option>';
                parentSelect.disabled = true;
            } else if (level === '2') {
                // Akan di-update dengan AJAX
                parentSelect.innerHTML = '<option value="">-- Pilih Parent Level 1 --</option>';
                parentSelect.disabled = false;
                loadParentsByLevel(1);
            } else if (level === '3') {
                // Akan di-update dengan AJAX
                parentSelect.innerHTML = '<option value="">-- Pilih Parent Level 2 --</option>';
                parentSelect.disabled = false;
                loadParentsByLevel(2);
            }
        }

        function loadParentsByLevel(level) {
            fetch(`{{ url('/api/unit-kerja/parents') }}?level=${level}`)
                .then(response => response.json())
                .then(data => {
                    const parentSelect = document.getElementById('parent_id');
                    let html = `<option value="">-- Pilih Parent --</option>`;
                    data.forEach(item => {
                        html += `<option value="${item.id}">${item.nama}</option>`;
                    });
                    parentSelect.innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateParentOptions();
        });
    </script>
@endsection
