@extends('layouts.admin')

@section('content')

<div class="container py-4" style="max-width: 900px;">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-user me-2"></i> Form Pegawai (Wizard)</h5>
        </div>

```
    <form action="{{ route('pegawai.store') }}" method="POST">
        @csrf

        <div class="card-body">

            <!-- STEP INDICATOR (CLICKABLE) -->
            <div class="d-flex justify-content-between mb-4 flex-wrap">
                <span class="step active" onclick="goToStep(0)">1. Identitas</span>
                <span class="step" onclick="goToStep(1)">2. Pensiun</span>
                <span class="step" onclick="goToStep(2)">3. Pangkat</span>
                <span class="step" onclick="goToStep(3)">4. Jabatan</span>
                <span class="step" onclick="goToStep(4)">5. Pendidikan</span>
                <span class="step" onclick="goToStep(5)">6. Unit</span>
            </div>

            <!-- STEP 1 -->
            <div class="step-content active">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>NIP *</label>
                        <input type="text" name="nip" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status ASN *</label>
                        <select name="status_asn" class="form-select" required>
                            <option value="">— Pilih —</option>
                            <option>PNS</option>
                            <option>PPPK</option>
                            <option>Honorer</option>
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

            <!-- STEP 2 -->
            <div class="step-content">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>BUP</label>
                        <select name="bup_tahun" class="form-select">
                            <option value="">— Pilih —</option>
                            <option>58</option>
                            <option>60</option>
                            <option>65</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Status Aktif *</label>
                        <select name="status_aktif" class="form-select" required>
                            <option value="">— Pilih —</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Tanggal Pensiun</label>
                        <input type="text" class="form-control bg-light" readonly>
                    </div>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="step-content">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Golongan *</label>
                        <select name="golongan" class="form-select" required>
                            <option value="">— Pilih —</option>
                            <option>I/a</option><option>I/b</option>
                            <option>II/a</option><option>II/b</option>
                            <option>III/a</option><option>III/b</option>
                            <option>IV/a</option><option>IV/b</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>TMT *</label>
                        <input type="date" name="tmt_golongan" class="form-control" required>
                    </div>
                </div>
            </div>

            <!-- STEP 4 -->
            <div class="step-content">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Jabatan *</label>
                        <input type="text" name="nama_jabatan" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>TMT Jabatan *</label>
                        <input type="date" name="tmt_jabatan" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label>Formasi</label>
                        <input type="text" name="formasi_jabatan" class="form-control">
                    </div>
                </div>
            </div>

            <!-- STEP 5 -->
            <div class="step-content">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Jenjang *</label>
                        <select name="jenjang_pendidikan" class="form-select" required>
                            <option value="">— Pilih —</option>
                            <option>SD</option><option>SMP</option>
                            <option>SMA</option><option>D3</option>
                            <option>S1</option><option>S2</option><option>S3</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tahun Lulus</label>
                        <input type="text" name="tahun_lulus" class="form-control">
                    </div>
                </div>
            </div>

            <!-- STEP 6 -->
            <div class="step-content">
                <div class="mb-3">
                    <label>Unit 1 *</label>
                    <select name="unit_kerja_1" class="form-select" required>
                        <option value="">— Pilih —</option>
                        <option>Dinas Pendidikan</option>
                        <option>Dinas Kesehatan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Unit 2 *</label>
                    <select name="unit_kerja_2" class="form-select" required>
                        <option value="">— Pilih —</option>
                        <option>Bidang 1</option>
                        <option>Bidang 2</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Unit 3 *</label>
                    <select name="unit_kerja_3" class="form-select" required>
                        <option value="">— Pilih —</option>
                        <option>Sub 1</option>
                        <option>Sub 2</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Unit 4 *</label>
                    <select name="unit_kerja_4" class="form-select" required>
                        <option value="">— Pilih —</option>
                        <option>Unit 1</option>
                        <option>Unit 2</option>
                    </select>
                </div>
            </div>

        </div>

        <!-- BUTTON -->
        <div class="card-footer d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" id="prevBtn">Back</button>
            <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
            <button type="submit" class="btn btn-success d-none" id="submitBtn">Simpan</button>
        </div>

    </form>
</div>
```

</div>

<style>
.step {
    cursor: pointer;
    font-size: 13px;
    opacity: 0.5;
    transition: 0.3s;
}
.step:hover {
    opacity: 1;
}
.step.active {
    font-weight: bold;
    opacity: 1;
    color: #0d6efd;
}
.step-content { display: none; }
.step-content.active { display: block; }
</style>

<script>
let currentStep = 0;
const steps = document.querySelectorAll(".step-content");
const indicators = document.querySelectorAll(".step");

function showStep(index) {
    currentStep = index;

    steps.forEach((step, i) => {
        step.classList.toggle("active", i === index);
        indicators[i].classList.toggle("active", i === index);
    });

    document.getElementById("prevBtn").style.display = index === 0 ? "none" : "inline-block";
    document.getElementById("nextBtn").style.display = index === steps.length - 1 ? "none" : "inline-block";
    document.getElementById("submitBtn").classList.toggle("d-none", index !== steps.length - 1);
}

function goToStep(index) {
    showStep(index);
}

document.getElementById("nextBtn").onclick = () => {
    if (currentStep < steps.length - 1) showStep(currentStep + 1);
};

document.getElementById("prevBtn").onclick = () => {
    if (currentStep > 0) showStep(currentStep - 1);
};

showStep(currentStep);
</script>

@endsection
