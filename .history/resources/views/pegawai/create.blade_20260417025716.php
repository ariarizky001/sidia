<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">

```
<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center px-3 py-2" style="background:#f5f6f8; border-radius:12px 12px 0 0;">
    <strong class="text-secondary">A. IDENTITAS PEGAWAI</strong>
    <button class="btn btn-light btn-sm rounded-circle">⋯</button>
</div>

<!-- BODY -->
<div class="card-body">

    <!-- NIP -->
    <div class="mb-3">
        <label class="form-label fw-semibold">
            NIP <span class="text-danger">*</span>
        </label>
        <input type="text"
               class="form-control form-control-lg"
               placeholder="Contoh: 196902061992032004">
        <small class="text-muted">
            18 digit — tanggal lahir, tahun CPNS, kode instansi akan terisi otomatis
        </small>
    </div>

    <!-- NAMA -->
    <div class="mb-3">
        <label class="form-label fw-semibold">
            Nama lengkap <span class="text-danger">*</span>
        </label>
        <input type="text"
               class="form-control form-control-lg"
               placeholder="Nama lengkap beserta gelar">
    </div>

    <!-- ROW -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">
                Tanggal lahir <span class="text-danger">*</span>
            </label>
            <input type="date" class="form-control form-control-lg">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">
                Status ASN <span class="text-danger">*</span>
            </label>
            <select class="form-select form-select-lg">
                <option>— Pilih —</option>
                <option>PNS</option>
                <option>PPPK</option>
                <option>Honorer</option>
            </select>
        </div>
    </div>

</div>
```

</div>

<style
.form-control-lg, .form-select-lg {
    height: 48px;
    font-size: 14px;
    border-radius: 8px;
}

.card-body {
    padding: 20px 24px;
}

label {
    font-size: 13px;
}
</style>
