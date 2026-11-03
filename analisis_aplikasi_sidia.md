# Analisis Aplikasi siDia
**Sistem Informasi Data Pegawai — Dinas Pendidikan**

---

## 1. Overview Aplikasi

**siDia** adalah sistem informasi berbasis **Laravel** (dengan AdminLTE sebagai template UI) yang digunakan oleh **Dinas Pendidikan** untuk mengelola data pegawai (guru & ASN), unit kerja (sekolah), dan mapping kebutuhan guru per Sekolah Dasar.

| Info | Detail |
|---|---|
| **Framework** | Laravel (PHP) |
| **UI Template** | AdminLTE 3 + Bootstrap 4 |
| **Database** | SQLite (aktif) |
| **Stack CSS** | Tailwind CSS + AdminLTE |

---

## 2. Struktur Menu Aplikasi

Sidebar navigasi (`layouts/admin.blade.php`) terbagi dalam **3 kelompok besar**:

### 🏠 Menu Utama

```
Dashboard
├── Data Pegawai (has-treeview)
│   ├── Semua Pegawai       → /pegawai
│   ├── Pegawai PNS         → /pegawai/status/pns
│   └── Pegawai PPPK        → /pegawai/status/pppk
├── Data Sekolah            → /data-sekolah
└── Mapping (has-treeview)
    ├── Rombel              → /rombel
    └── Kebutuhan Guru      → /kebutuhan-guru
```

### 🗄️ Master Data (has-treeview)

```
Master Data
├── Status ASN              → /status-asn
├── Golongan                → /golongan
├── Eselon                  → /eselon
├── Jabatan                 → /jabatan
├── Formasi Jabatan         → /formasi-jabatan
├── Jenjang Pendidikan      → /jenjang-pendidikan
└── Unit Kerja              → /unit-kerja
```

### ⚙️ Pengaturan

```
Pengaturan
└── Profile                 → /profile
```

---

## 3. Routes Lengkap

| Method | Route | Controller | Keterangan |
|---|---|---|---|
| GET | `/dashboard` | — | Dashboard utama |
| GET/POST/PUT/DELETE | `/pegawai` | `PegawaiController` | CRUD pegawai |
| GET | `/pegawai/import/form` | `PegawaiController@importForm` | Form import Excel |
| POST | `/pegawai/import/process` | `PegawaiController@processImport` | Proses import |
| GET | `/pegawai/import/template` | `PegawaiController@downloadTemplate` | Template Excel |
| GET | `/pegawai/status/pns` | `PegawaiController@pns` | Filter hanya PNS |
| GET | `/pegawai/status/pppk` | `PegawaiController@pppk` | Filter hanya PPPK |
| GET | `/data-sekolah` | `DataSekolahController` | Index + Show saja |
| GET/POST/PUT/DELETE | `/rombel` | `RombelController` | CRUD Rombel |
| POST | `/rombel/store-inline` | `RombelController@storeInline` | Simpan inline |
| PATCH | `/rombel/{id}/update-inline` | `RombelController@updateInline` | Edit inline |
| GET/POST/PUT/DELETE | `/kebutuhan-guru` | `KebutuhanGuruController` | CRUD Kebutuhan |
| GET/POST/PUT/DELETE | `/status-asn` | `StatusAsnController` | CRUD Status ASN |
| GET/POST/PUT/DELETE | `/golongan` | `GolonganController` | CRUD Golongan |
| GET/POST/PUT/DELETE | `/eselon` | `EselonController` | CRUD Eselon |
| GET/POST/PUT/DELETE | `/jabatan` | `JabatanController` | CRUD Jabatan |
| GET/POST/PUT/DELETE | `/formasi-jabatan` | `FormasiJabatanController` | CRUD Formasi Jabatan |
| GET/POST/PUT/DELETE | `/jenjang-pendidikan` | `JenjangPendidikanController` | CRUD Jenjang |
| GET/POST/PUT/DELETE | `/unit-kerja` | `UnitKerjaController` | CRUD Unit Kerja |
| GET | `/unit-kerja/import/form` | `UnitKerjaController@importForm` | Form import Excel |
| POST | `/unit-kerja/import/process` | `UnitKerjaController@processImport` | Proses import |

**API Routes Internal (untuk dropdown dinamis):**

| Route | Fungsi |
|---|---|
| `GET /api/pegawai/unit-kerja/level1` | Ambil unit kerja level 1 |
| `GET /api/pegawai/unit-kerja/children/{parentId}` | Ambil anak unit kerja |
| `GET /api/unit-kerja/parents` | Ambil parent by level |
| `GET /api/unit-kerja/children/{parentId}/{level}` | Ambil children by parent |

---

## 4. Struktur Database

### 4.1 Diagram Relasi Tabel

```
users
  └─ (auth saja)

unit_kerjas  (hierarki: level 1→2→3)
  ├─ parent_id → unit_kerjas.id (self-referencing)
  ├─ ← rombels.unit_kerja_parent_id
  ├─ ← rombels.unit_kerja_id
  ├─ ← pegawais.unit_kerja_1_id
  ├─ ← pegawais.unit_kerja_2_id
  └─ ← pegawais.unit_kerja_3_id

golongans
  └─ ← pegawais.golongan_id

status_asns
  └─ ← pegawais.status_asn_id

jenjang_pendidikans
  └─ ← pegawais.jenjang_pendidikan_id

eselons
  ├─ ← jabatans.eselon_id
  └─ ← pegawais.eselon_id

jabatans
  ├─ parent_id → jabatans.id (self-referencing)
  ├─ eselon_id → eselons.id
  └─ ← pegawais.jabatan_id

formasi_jabatans
  └─ ← pegawais.formasi_jabatan_id

pegawais (tabel utama)
  ├─ golongan_id       → golongans
  ├─ status_asn_id     → status_asns
  ├─ jenjang_pendidikan_id → jenjang_pendidikans
  ├─ eselon_id         → eselons
  ├─ jabatan_id        → jabatans
  ├─ formasi_jabatan_id → formasi_jabatans
  ├─ unit_kerja_1_id   → unit_kerjas (Dinas/Induk)
  ├─ unit_kerja_2_id   → unit_kerjas (Korwil/Kecamatan)
  └─ unit_kerja_3_id   → unit_kerjas (Sekolah)

rombels
  ├─ unit_kerja_parent_id → unit_kerjas (Level 2: Korwil)
  └─ unit_kerja_id        → unit_kerjas (Level 3: Sekolah)
```

### 4.2 Detail Tabel

#### `users`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| name | string | |
| email | string UNIQUE | |
| email_verified_at | timestamp nullable | |
| password | string | |
| remember_token | string | |

#### `unit_kerjas` ⭐ (Hierarki 3 Level)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| nama | varchar(100) | Nama unit kerja |
| parent_id | bigint nullable FK | Self-referencing |
| level | int default(1) | 1=Induk/Dinas, 2=Korwil/Kecamatan, 3=Sekolah |

#### `pegawais` ⭐ (Tabel Inti)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| nip | string UNIQUE | Nomor Induk Pegawai |
| nama_lengkap | varchar(100) | |
| tgl_lahir | date | |
| pensiun | date nullable | |
| bup | int nullable | Batas Usia Pensiun |
| golongan_id | bigint FK → golongans | |
| tmt_golongan | date nullable | |
| jabatan_id | bigint FK → jabatans | |
| tmt_jabatan | date nullable | |
| eselon_id | bigint FK → eselons | |
| tmt_cpns | date nullable | |
| jenjang_pendidikan_id | bigint FK → jenjang_pendidikans | |
| thn_lulus | int nullable | |
| status_asn_id | bigint FK → status_asns | |
| status_aktif | boolean | |
| formasi_jabatan_id | bigint FK → formasi_jabatans | |
| unit_kerja_1_id | bigint FK → unit_kerjas | Level 1: Dinas |
| unit_kerja_2_id | bigint FK → unit_kerjas | Level 2: Korwil |
| unit_kerja_3_id | bigint FK → unit_kerjas | Level 3: Sekolah |

#### `golongans`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| nama_golongan | varchar(20) UNIQUE | |
| kode | string nullable | |
| kode_urutan | int nullable | Untuk pengurutan |
| deskripsi | text nullable | |
| status | enum(aktif,nonaktif) | |

#### `status_asns`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| kode | string nullable | |
| nama | string | misal: PNS, PPPK, Honorer |
| aktif | boolean default(true) | |

#### `jenjang_pendidikans`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| kode | string nullable | |
| nama_jenjang | varchar(50) UNIQUE | misal: S1, S2, D3 |
| deskripsi | text nullable | |
| status | enum(aktif,nonaktif) | |

#### `eselons`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| kode | varchar(10) UNIQUE | |
| nama_eselon | varchar(100) | |
| deskripsi | text nullable | |
| status | enum(aktif,nonaktif) | |

#### `jabatans`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| nama_jabatan | varchar(100) | |
| jenis_jabatan | enum(struktural,fungsional,non-struktural) | |
| eselon_id | bigint FK → eselons nullable | |
| parent_id | bigint FK → jabatans nullable | Hierarki jabatan |
| is_active | boolean default(true) | |

#### `formasi_jabatans`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| nama_formasi | varchar(100) | misal: Guru Kelas SD |
| jenis_jabatan | enum(struktural,fungsional) | |
| kategori | varchar(100) nullable | |
| is_active | boolean default(true) | |

#### `rombels` ⭐ (Rombongan Belajar)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| unit_kerja_parent_id | bigint FK → unit_kerjas nullable | Korwil/Kecamatan (Level 2) |
| unit_kerja_id | bigint FK → unit_kerjas | Sekolah (Level 3) |
| jumlah_rombel | int default(0) | Jumlah rombongan belajar |
| keterangan | text nullable | |

---

## 5. Models & Relasi Eloquent

| Model | Tabel | Relasi Utama |
|---|---|---|
| `Pegawai` | pegawais | belongsTo: Golongan, Eselon, StatusAsn, Jabatan, FormasiJabatan, JenjangPendidikan, UnitKerja (3x) |
| `UnitKerja` | unit_kerjas | belongsTo: parent (self), hasMany: children (self), hasMany: Rombel, hasMany: Pegawai |
| `Jabatan` | jabatans | belongsTo: Eselon, belongsTo: parent (self), hasMany: children (self) |
| `FormasiJabatan` | formasi_jabatans | — |
| `Golongan` | golongans | — |
| `Eselon` | eselons | — |
| `Status/StatusAsn` | status_asns | — |
| `JenjangPendidikan` | jenjang_pendidikans | — |
| `Rombel` | rombels | belongsTo: UnitKerja (2x) |

---

## 6. Controllers & Fitur

| Controller | Fitur Utama |
|---|---|
| `PegawaiController` | CRUD lengkap, Import Excel, Filter PNS/PPPK, API dropdown unit kerja |
| `UnitKerjaController` | CRUD hierarki 3 level, Import Excel, API dropdown parent/children |
| `RombelController` | CRUD + inline edit per sekolah |
| `KebutuhanGuruController` | Kalkulasi kebutuhan guru per formasi per sekolah |
| `DataSekolahController` | Hanya index + show (read-only) |
| `GolonganController` | CRUD |
| `EselonController` | CRUD |
| `JabatanController` | CRUD dengan hierarki |
| `FormasiJabatanController` | CRUD |
| `JenjangPendidikanController` | CRUD |
| `StatusAsnController` | CRUD |

---

## 7. Fitur Yang Sudah Ada (Existing)

✅ Authentication (Login/Register/Logout via Laravel Breeze)  
✅ CRUD Data Pegawai (PNS, PPPK, semua)  
✅ Import Pegawai dari Excel  
✅ CRUD Master Data (Golongan, Eselon, Jabatan, Formasi, dll)  
✅ CRUD Unit Kerja (hierarki 3 level)  
✅ Import Unit Kerja dari Excel  
✅ CRUD Rombel (inline edit per sekolah)  
✅ Kebutuhan Guru (mapping dasar)  
✅ Data Sekolah (read-only view)  
✅ Sidebar dengan state collapse/expand (localStorage)  

---

## 8. Roadmap Pengembangan (Dari Dokumen Perancangan)

Berdasarkan [Perancangan_Sistem_Mapping_Guru_SD.md](file:///d:/bapak/siDia/Perancangan_Sistem_Mapping_Guru_SD.md), fitur yang **belum diimplementasi**:

| Prioritas | Fitur | Keterangan |
|---|---|---|
| 🔴 Tinggi | **Tabel `riwayat_mutasi`** | Belum ada migration/tabel ini |
| 🔴 Tinggi | **Proses Mutasi Guru** | Pindah guru antar sekolah (atomic transaction) |
| 🔴 Tinggi | **Halaman Mapping Lengkap** | Status per formasi (LENGKAP/PARSIAL/KOSONG) |
| 🟡 Sedang | **Detail per Sekolah** | Slot guru + status per formasi |
| 🟡 Sedang | **Modal Tarik Guru** | Pilih guru untuk dipindahkan |
| 🟡 Sedang | **Riwayat Mutasi** | Log semua perpindahan guru |
| 🟢 Rendah | **Laporan .docx** | Laporan kebutuhan per sekolah |
| 🟢 Rendah | **Export .xlsx** | Rekap semua sekolah |
| 🟢 Rendah | **Dashboard dinamis** | Widget dengan data real (sekarang masih hardcode 0) |

---

## 9. Catatan Penting untuk Pengembangan

> [!IMPORTANT]
> **Unit Kerja Level 3 = Sekolah Dasar.** Saat mapping guru, selalu gunakan `unit_kerja_3_id` pada tabel `pegawais`.

> [!WARNING]
> **Tabel `riwayat_mutasi` BELUM ADA** di database. Ini perlu dibuat sebelum fitur mutasi bisa diimplementasi.

> [!NOTE]
> **Dashboard saat ini masih statis** — semua angka (Total Pegawai, Departemen, dll) bernilai 0 hardcode. Perlu dihubungkan ke query database yang sebenarnya.

> [!TIP]
> **Formasi Jabatan yang digunakan untuk mapping guru SD**: `Guru Kelas SD`, `Guru Penjas SD`, `Guru Agama SD` — ketiganya harus ada di tabel `formasi_jabatans`.
