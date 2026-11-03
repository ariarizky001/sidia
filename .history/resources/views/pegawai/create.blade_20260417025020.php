@extends('layouts.admin')

@section('content')

<div class="container py-4" style="max-width: 1000px;">
    <div class="card shadow-sm">

```
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-users me-2"></i> Form Data Pegawai</h5>
    </div>

    <form action="{{ route('pegawai.store') }}" method="POST">
        @csrf

        <div class="card-body">

            <div class="accordion" id="formPegawai">

                <!-- A -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#a">
                            A. Identitas Pegawai
                        </button>
                    </h2>
                    <div id="a" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>NIP *</label>
                                    <input type="text" name="nip" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Status ASN *</label>
                                    <select name="status_asn" class="form-select">
                                        <option>PNS</option>
                                        <option>PPPK</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Nama Lengkap *</label>
                                    <input type="text" name="nama_lengkap" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Lahir *</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- B -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#b">
                            B. Pensiun
                        </button>
                    </h2>
                    <div id="b" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>BUP</label>
                                    <select name="bup_tahun" class="form-select">
                                        <option>58</option>
                                        <option>60</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Status Aktif</label>
                                    <select name="status_aktif" class="form-select">
                                        <option>Aktif</option>
                                        <option>Nonaktif</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Tanggal Pensiun</label>
                                    <input type="text" class="form-control bg-light" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- C -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#c">
                            C. Kepangkatan
                        </button>
                    </h2>
                    <div id="c" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Golongan</label>
                                    <select name="golongan" class="form-select"></select>
                                </div>
                                <div class="col-md-6">
                                    <label>TMT</label>
                                    <input type="date" name="tmt_golongan" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- D -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#d">
                            D. Jabatan
                        </button>
                    </h2>
                    <div id="d" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <input type="text" name="nama_jabatan" class="form-control mb-2" placeholder="Nama Jabatan">
                            <input type="date" name="tmt_jabatan" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- E -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#e">
                            E. Pendidikan
                        </button>
                    </h2>
                    <div id="e" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <select name="jenjang_pendidikan" class="form-select mb-2"></select>
                            <input type="text" name="tahun_lulus" class="form-control">
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="card-footer text-end">
            <button class="btn btn-success">Simpan</button>
        </div>

    </form>

</div>
```

</div>

@endsection
