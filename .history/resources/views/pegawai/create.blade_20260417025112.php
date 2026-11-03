@extends('layouts.admin')

@section('content')

<div class="container py-4" style="max-width: 1100px;">

```
<!-- 🔵 HEADER PREVIEW -->
<div class="card mb-3 shadow-sm">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0" id="previewNama">Nama Pegawai</h5>
            <small class="text-muted" id="previewNip">NIP: -</small>
        </div>
        <div class="text-end">
            <span class="badge bg-success" id="previewStatus">Aktif</span>
        </div>
    </div>
</div>

<form action="{{ route('pegawai.store') }}" method="POST">
    @csrf

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
                            <input type="text" name="nip" class="form-control" id="nip">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nama Lengkap *</label>
                            <input type="text" name="nama_lengkap" class="form-control" id="nama">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Status ASN</label>
                            <select name="status_asn" class="form-select">
                                <option>PNS</option>
                                <option>PPPK</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" id="tglLahir">
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
                        <div class="col-md-4 mb-3">
                            <label>BUP</label>
                            <select name="bup_tahun" class="form-select" id="bup">
                                <option value="">Pilih</option>
                                <option value="58">58</option>
                                <option value="60">60</option>
                                <option value="65">65</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Status Aktif</label>
                            <select name="status_aktif" class="form-select" id="statusAktif">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Tanggal Pensiun</label>
                            <input type="text" class="form-control bg-light" id="pensiun" readonly>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- 🔴 STICKY BUTTON -->
    <div class="sticky-footer bg-white p-3 shadow-sm d-flex justify-content-end gap-2">
        <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>

</form>
```

</div>

<style>
.sticky-footer {
    position: sticky;
    bottom: 0;
    z-index: 10;
}

.accordion-button {
    font-weight: 600;
}

.accordion-item {
    border-radius: 8px;
    margin-bottom: 10px;
    overflow: hidden;
}
</style>

<script>
// 🔥 LIVE PREVIEW
document.getElementById('nama').oninput = e => {
    document.getElementById('previewNama').innerText = e.target.value || 'Nama Pegawai';
};
document.getElementById('nip').oninput = e => {
    document.getElementById('previewNip').innerText = "NIP: " + (e.target.value || '-');
};
document.getElementById('statusAktif').onchange = e => {
    document.getElementById('previewStatus').innerText = e.target.value;
};

// 🔥 AUTO HITUNG PENSIUN
function hitungPensiun() {
    let tgl = document.getElementById('tglLahir').value;
    let bup = document.getElementById('bup').value;

    if (tgl && bup) {
        let date = new Date(tgl);
        date.setFullYear(date.getFullYear() + parseInt(bup));
        document.getElementById('pensiun').value = date.toISOString().split('T')[0];
    }
}

document.getElementById('tglLahir').onchange = hitungPensiun;
document.getElementById('bup').onchange = hitungPensiun;

</script>

@endsection
