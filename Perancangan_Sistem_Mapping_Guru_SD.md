# Dokumen Perancangan Sistem
## Sistem Informasi Mapping & Mutasi Guru SD — Dinas Pendidikan

| | |
|---|---|
| **Nama Sistem** | Sistem Informasi Mapping & Mutasi Guru SD |
| **Versi Dokumen** | 1.0 |
| **Tanggal** | Juni 2025 |
| **Dibuat untuk** | AI Agent / Developer |
| **Cakupan** | Modul Mapping Guru, Mutasi, dan Laporan |

---

## 1. Gambaran Umum Sistem

### 1.1 Latar Belakang

Dinas Pendidikan memiliki ratusan Sekolah Dasar (SD) yang tersebar di berbagai kecamatan. Setiap sekolah membutuhkan tiga jenis formasi guru: Guru Kelas SD, Guru Pendidikan Jasmani SD, dan Guru Agama SD. Kebutuhan Guru Kelas mengikuti jumlah rombongan belajar (rombel) di sekolah tersebut, sedangkan Guru Penjas dan Guru Agama masing-masing 1 orang per sekolah.

Sistem ini dibangun untuk menganalisa pemenuhan guru per sekolah, memfasilitasi proses mutasi/rotasi guru antar sekolah, dan menghasilkan laporan kebutuhan secara otomatis.

### 1.2 Ruang Lingkup

- **Menu Mapping**: menampilkan status pemenuhan 3 formasi guru untuk setiap SD
- **Detail per Sekolah**: menampilkan nama guru yang bertugas beserta slot kosong
- **Proses Mutasi**: memindahkan unit kerja guru dari satu sekolah ke sekolah lain
- **Riwayat Rotasi**: mencatat semua perubahan penugasan per tahun ajaran
- **Laporan**: mencetak laporan kebutuhan guru per sekolah dalam format `.docx`

### 1.3 Definisi Penting

| Istilah | Definisi |
|---|---|
| **Unit Kerja** | Satuan organisasi tempat pegawai bertugas. Untuk SD, jenis unit kerja = 3. |
| **Formasi Jabatan** | Spesialisasi guru: `guru_kelas_sd` \| `guru_penjas_sd` \| `guru_agama_sd` |
| **Rombel** | Rombongan Belajar. Jumlah rombel menentukan kebutuhan Guru Kelas. |
| **Mapping** | Pemetaan ketersediaan guru per formasi per sekolah. |
| **Mutasi** | Perpindahan unit kerja guru dari sekolah asal ke sekolah tujuan. |
| **Slot** | Posisi formasi yang harus diisi guru. Slot kosong = kekurangan guru. |
| **Tahun Ajaran** | Periode aktif penugasan guru, format: `YYYY/YYYY` (contoh: `2024/2025`). |

---

## 2. Desain Database

### 2.1 Entity Relationship

Sistem menggunakan 5 tabel utama. Berikut relasi antar tabel:

| Tabel A | Tabel B | Relasi |
|---|---|---|
| `unit_kerja` | `pegawai` | 1 unit_kerja → banyak pegawai (via unit_kerja_id) |
| `unit_kerja` | `rombel` | 1 unit_kerja → banyak rombel |
| `pegawai` | `riwayat_mutasi` | 1 pegawai → banyak riwayat mutasi |
| `unit_kerja` | `riwayat_mutasi` | 1 unit_kerja → sebagai asal/tujuan mutasi |

### 2.2 Struktur Tabel

#### Tabel: `unit_kerja`

Menyimpan data semua unit kerja. SD diidentifikasi dengan `jenis = 3`.

| Kolom | Tipe | Constraint | Keterangan |
|---|---|---|---|
| `id` | BIGINT | PK, AI | Primary key |
| `kode_unit` | VARCHAR(20) | UNIQUE | Kode unik unit kerja |
| `nama_sekolah` | VARCHAR(150) | NOT NULL | Nama lengkap sekolah |
| `npsn` | VARCHAR(20) | UNIQUE | Nomor Pokok Sekolah Nasional |
| `kecamatan` | VARCHAR(100) | | Nama kecamatan |
| `jenis` | TINYINT | NOT NULL | 3 = SD, nilai lain = jenjang lain |
| `jumlah_rombel` | INT | DEFAULT 0 | Jumlah rombongan belajar aktif |
| `is_aktif` | TINYINT(1) | DEFAULT 1 | 1 = aktif, 0 = tidak aktif |
| `created_at` | TIMESTAMP | | |
| `updated_at` | TIMESTAMP | | |

#### Tabel: `pegawai`

Data pokok pegawai/guru. Kolom `unit_kerja_id` menentukan guru bertugas di sekolah mana.

| Kolom | Tipe | Constraint | Keterangan |
|---|---|---|---|
| `id` | BIGINT | PK, AI | Primary key |
| `nip` | VARCHAR(30) | UNIQUE | Nomor Induk Pegawai |
| `nama` | VARCHAR(150) | NOT NULL | Nama lengkap guru |
| `unit_kerja_id` | BIGINT | FK → unit_kerja | Sekolah tempat bertugas saat ini |
| `formasi_jabatan` | ENUM | NOT NULL | `guru_kelas_sd` \| `guru_penjas_sd` \| `guru_agama_sd` |
| `tgl_lahir` | DATE | | Tanggal lahir |
| `jenis_kelamin` | CHAR(1) | | L / P |
| `golongan` | VARCHAR(10) | | Golongan kepangkatan |
| `status_kepegawaian` | VARCHAR(30) | | PNS \| PPPK \| Honorer |
| `is_aktif` | TINYINT(1) | DEFAULT 1 | 1 = aktif bertugas |
| `created_at` | TIMESTAMP | | |
| `updated_at` | TIMESTAMP | | |

#### Tabel: `rombel`

Data rombongan belajar per sekolah. Jumlah baris per sekolah menentukan kebutuhan Guru Kelas.

| Kolom | Tipe | Constraint | Keterangan |
|---|---|---|---|
| `id` | BIGINT | PK, AI | |
| `unit_kerja_id` | BIGINT | FK → unit_kerja | Sekolah pemilik rombel |
| `nama_rombel` | VARCHAR(50) | NOT NULL | Contoh: Kelas I, Kelas II, dst |
| `tahun_ajaran` | VARCHAR(10) | NOT NULL | Format: `2024/2025` |
| `is_aktif` | TINYINT(1) | DEFAULT 1 | |

#### Tabel: `riwayat_mutasi`

Mencatat setiap perpindahan unit kerja guru. Tabel ini adalah sumber data laporan rotasi.

| Kolom | Tipe | Constraint | Keterangan |
|---|---|---|---|
| `id` | BIGINT | PK, AI | |
| `pegawai_id` | BIGINT | FK → pegawai | Guru yang dimutasi |
| `unit_kerja_asal_id` | BIGINT | FK → unit_kerja | Sekolah sebelumnya (NULL jika pertama kali) |
| `unit_kerja_tujuan_id` | BIGINT | FK → unit_kerja | Sekolah tujuan |
| `tahun_ajaran` | VARCHAR(10) | NOT NULL | Tahun ajaran berlaku: `2024/2025` |
| `tgl_efektif` | DATE | NOT NULL | Tanggal mulai berlaku mutasi |
| `keterangan` | TEXT | | Alasan / catatan mutasi |
| `created_by` | BIGINT | FK → users | User admin yang memproses |
| `created_at` | TIMESTAMP | | |

---

## 3. Query SQL Utama

### 3.1 Query: Daftar Mapping Semua Sekolah

Digunakan di halaman utama mapping. Menampilkan status per formasi per sekolah sekaligus.

```sql
SELECT
  uk.id,
  uk.nama_sekolah,
  uk.kecamatan,
  uk.jumlah_rombel,
  -- Guru Kelas
  COUNT(CASE WHEN p.formasi_jabatan = 'guru_kelas_sd' THEN 1 END) AS jml_guru_kelas,
  -- Guru Penjas
  COUNT(CASE WHEN p.formasi_jabatan = 'guru_penjas_sd' THEN 1 END) AS jml_guru_penjas,
  -- Guru Agama
  COUNT(CASE WHEN p.formasi_jabatan = 'guru_agama_sd' THEN 1 END) AS jml_guru_agama,
  -- Status: LENGKAP | PARSIAL | KOSONG
  CASE
    WHEN COUNT(CASE WHEN p.formasi_jabatan='guru_kelas_sd' THEN 1 END) >= uk.jumlah_rombel
      AND COUNT(CASE WHEN p.formasi_jabatan='guru_penjas_sd' THEN 1 END) >= 1
      AND COUNT(CASE WHEN p.formasi_jabatan='guru_agama_sd' THEN 1 END) >= 1
      THEN 'LENGKAP'
    WHEN COUNT(p.id) = 0 THEN 'KOSONG'
    ELSE 'PARSIAL'
  END AS status
FROM unit_kerja uk
LEFT JOIN pegawai p ON p.unit_kerja_id = uk.id AND p.is_aktif = 1
WHERE uk.jenis = 3 AND uk.is_aktif = 1
GROUP BY uk.id
ORDER BY uk.kecamatan, uk.nama_sekolah;
```

### 3.2 Query: Detail Guru per Sekolah

```sql
-- A. Guru yang sudah ada di sekolah ini
SELECT p.id, p.nama, p.nip, p.formasi_jabatan, p.golongan, p.status_kepegawaian
FROM pegawai p
WHERE p.unit_kerja_id = :sekolah_id AND p.is_aktif = 1
ORDER BY p.formasi_jabatan, p.nama;

-- B. Hitung kebutuhan vs tersedia
SELECT
  uk.jumlah_rombel AS kebutuhan_kelas,
  1 AS kebutuhan_penjas,
  1 AS kebutuhan_agama,
  COUNT(CASE WHEN p.formasi_jabatan='guru_kelas_sd' THEN 1 END) AS ada_kelas,
  COUNT(CASE WHEN p.formasi_jabatan='guru_penjas_sd' THEN 1 END) AS ada_penjas,
  COUNT(CASE WHEN p.formasi_jabatan='guru_agama_sd' THEN 1 END) AS ada_agama
FROM unit_kerja uk
LEFT JOIN pegawai p ON p.unit_kerja_id = uk.id AND p.is_aktif = 1
WHERE uk.id = :sekolah_id
GROUP BY uk.id;
```

### 3.3 Query: Pilih Guru untuk Ditarik (Modal Assign)

```sql
SELECT
  p.id, p.nama, p.nip, p.formasi_jabatan,
  uk.nama_sekolah AS sekolah_asal,
  uk.id AS unit_kerja_asal_id
FROM pegawai p
LEFT JOIN unit_kerja uk ON uk.id = p.unit_kerja_id
WHERE p.formasi_jabatan = :formasi
  AND p.is_aktif = 1
  AND (p.unit_kerja_id IS NULL OR p.unit_kerja_id != :sekolah_tujuan_id)
ORDER BY (p.unit_kerja_id IS NULL) DESC, p.nama;
```

> Guru tanpa unit kerja (`NULL`) diurutkan ke atas karena tidak memerlukan proses mutasi.

### 3.4 Query: Riwayat Mutasi per Sekolah / per Tahun Ajaran

```sql
SELECT
  rm.id, rm.tgl_efektif, rm.tahun_ajaran, rm.keterangan,
  p.nama AS nama_guru, p.nip, p.formasi_jabatan,
  uk_asal.nama_sekolah AS dari_sekolah,
  uk_tujuan.nama_sekolah AS ke_sekolah
FROM riwayat_mutasi rm
JOIN pegawai p ON p.id = rm.pegawai_id
LEFT JOIN unit_kerja uk_asal ON uk_asal.id = rm.unit_kerja_asal_id
JOIN unit_kerja uk_tujuan ON uk_tujuan.id = rm.unit_kerja_tujuan_id
WHERE rm.tahun_ajaran = :tahun_ajaran   -- opsional
  AND (rm.unit_kerja_asal_id = :sekolah_id OR rm.unit_kerja_tujuan_id = :sekolah_id)
ORDER BY rm.tgl_efektif DESC;
```

---

## 4. Alur Bisnis (Business Logic)

### 4.1 Proses Mutasi Guru

Ketika admin memproses mutasi, sistem harus menjalankan operasi berikut secara atomik (dalam satu transaksi database):

1. Validasi: pastikan guru dengan `id = :pegawai_id` dan `is_aktif = 1` ada di database.
2. Catat asal: ambil `unit_kerja_id` lama dari tabel pegawai sebagai `unit_kerja_asal_id`.
3. Insert ke `riwayat_mutasi`: isi semua kolom termasuk `tgl_efektif` dan `tahun_ajaran`.
4. Update `pegawai`: set `unit_kerja_id = :unit_kerja_tujuan_id` dan `updated_at = NOW()`.
5. Commit transaksi. Jika ada error di langkah manapun, rollback semua.

```sql
BEGIN TRANSACTION;
  INSERT INTO riwayat_mutasi (pegawai_id, unit_kerja_asal_id, unit_kerja_tujuan_id,
    tahun_ajaran, tgl_efektif, keterangan, created_by)
  VALUES (:pgw_id, :asal_id, :tujuan_id, :ta, :tgl, :ket, :user_id);

  UPDATE pegawai
  SET unit_kerja_id = :tujuan_id, updated_at = NOW()
  WHERE id = :pgw_id;
COMMIT;
```

### 4.2 Logika Perhitungan Status Sekolah

| Status | Kondisi | Warna UI |
|---|---|---|
| **LENGKAP** | Semua 3 formasi terpenuhi sesuai kebutuhan | Hijau (`#D6EFD8` / `#1A6B22`) |
| **PARSIAL** | Minimal 1 formasi ada, tapi ada yang masih kurang | Kuning (`#FAEEDA` / `#854F0B`) |
| **KOSONG** | Tidak ada satu pun guru di sekolah ini | Merah (`#FCE4D6` / `#9C2B1B`) |

- Kebutuhan Guru Kelas = `jumlah_rombel` sekolah tersebut
- Kebutuhan Guru Penjas = 1 per sekolah (flat)
- Kebutuhan Guru Agama = 1 per sekolah (flat)

### 4.3 Aturan Validasi

- Guru `is_aktif = 0` tidak boleh muncul di mapping maupun pilihan mutasi.
- Satu guru hanya bisa memiliki satu `unit_kerja_id` aktif pada satu waktu.
- Mutasi ke sekolah yang sama tidak diperbolehkan (`unit_kerja_asal_id != unit_kerja_tujuan_id`).
- Formasi guru harus sesuai: hanya `guru_kelas_sd` yang bisa mengisi slot guru kelas, dst.
- `tgl_efektif` mutasi tidak boleh lebih kecil dari tanggal hari ini.

---

## 5. Struktur Menu & Halaman

### 5.1 Peta Halaman

| Nama Halaman | Route | Fungsi Utama |
|---|---|---|
| Daftar Mapping Sekolah | `/mapping` | Tabel semua SD + status 3 formasi + filter + export |
| Detail Mapping Sekolah | `/mapping/:id` | Detail guru per formasi + slot kosong + tarik guru |
| Modal: Tarik Guru | (overlay di `/mapping/:id`) | Pilih guru dari data pokok untuk dimutasi ke sekolah ini |
| Form Konfirmasi Mutasi | `/mutasi/konfirmasi` | Input tgl efektif, keterangan, lalu proses mutasi |
| Riwayat Mutasi | `/mutasi/riwayat` | Log semua mutasi, filter by sekolah/tahun ajaran/formasi |
| Laporan Kebutuhan | `/laporan/:id` | Preview + unduh `.docx` laporan kebutuhan guru sekolah |

### 5.2 Komponen Halaman Daftar Mapping (`/mapping`)

- Filter: dropdown kecamatan, dropdown status (Lengkap/Parsial/Kosong), dropdown formasi, input search nama sekolah
- Summary cards: Total SD | Lengkap | Parsial | Kosong
- Tabel: Nama Sekolah | Guru Kelas | Guru Penjas | Guru Agama | Status badge | Tombol Detail
- Tombol Export: generate `.docx` atau `.xlsx` rekapitulasi seluruh sekolah

### 5.3 Komponen Halaman Detail (`/mapping/:id`)

- Header sekolah: nama, kecamatan, jumlah rombel, chip status per formasi
- Per blok formasi: judul formasi, hitungan kebutuhan vs tersedia, daftar slot
- Slot terisi: avatar inisial + nama + NIP + tombol Mutasi
- Slot kosong: ditandai garis putus-putus + tombol Tarik Guru
- Tombol Laporan: generate `.docx` laporan kebutuhan sekolah ini

### 5.4 Komponen Modal Tarik Guru

- Judul: formasi yang sedang diisi
- Input search: filter nama / NIP
- Daftar guru: avatar + nama + NIP + chip sekolah asal (atau "Belum ada sekolah")
- Tombol Pilih → redirect ke form konfirmasi mutasi

---

## 6. Spesifikasi API Endpoint

| Method | Endpoint | Auth | Deskripsi |
|---|---|---|---|
| GET | `/api/mapping` | Required | Daftar semua SD + status formasi. Query: `?kecamatan=&status=&formasi=&q=` |
| GET | `/api/mapping/:id` | Required | Detail sekolah: guru per formasi + slot kosong + hitungan kebutuhan |
| GET | `/api/pegawai/tersedia` | Required | List guru untuk modal assign. Query: `?formasi=&exclude_sekolah=` |
| POST | `/api/mutasi` | Required | Proses mutasi. Body: `{pegawai_id, unit_kerja_tujuan_id, tgl_efektif, tahun_ajaran, keterangan}` |
| GET | `/api/mutasi/riwayat` | Required | Log mutasi. Query: `?sekolah_id=&tahun_ajaran=&formasi=` |
| GET | `/api/laporan/:sekolah_id` | Required | Download `.docx` laporan kebutuhan guru sekolah |
| GET | `/api/mapping/export` | Required | Download `.xlsx` / `.docx` rekapitulasi semua sekolah |

### 6.1 Contoh Request & Response: `POST /api/mutasi`

**Request Body:**
```json
{
  "pegawai_id": 142,
  "unit_kerja_tujuan_id": 37,
  "tgl_efektif": "2025-07-14",
  "tahun_ajaran": "2025/2026",
  "keterangan": "Pemenuhan kebutuhan guru kelas SDN 03 Margaasih"
}
```

**Response Sukses (200):**
```json
{
  "success": true,
  "message": "Mutasi berhasil diproses",
  "data": {
    "riwayat_id": 89,
    "pegawai": "Yusuf Permana",
    "dari": "SDN 11 Soreang",
    "ke": "SDN 03 Margaasih",
    "tgl_efektif": "2025-07-14"
  }
}
```

**Response Error (422):**
```json
{ "success": false, "message": "Formasi guru tidak sesuai dengan slot yang dibutuhkan" }
```

---

## 7. Modul Laporan

### 7.1 Laporan Kebutuhan Guru per Sekolah (`.docx`)

Dihasilkan dari endpoint `GET /api/laporan/:sekolah_id`. Struktur dokumen:

1. Cover: Judul, nama sekolah, NPSN, kecamatan, tahun ajaran, tanggal cetak
2. A. Informasi Sekolah: tabel data dasar sekolah
3. B. Rekapitulasi: tabel ringkasan 3 formasi (kebutuhan | tersedia | kekurangan | status)
4. C. Detail Per Formasi: tabel per formasi dengan nama guru + NIP, baris merah untuk slot kosong
5. D. Rekomendasi: tabel kebutuhan tambahan (formasi apa, berapa orang)
6. Halaman terakhir: kolom tanda tangan Kepala Sekolah dan Admin Dinas

### 7.2 Laporan Rekap Semua Sekolah (`.xlsx`)

Dari endpoint `GET /api/mapping/export`. Kolom:
- No | Kecamatan | Nama Sekolah | NPSN | Jml Rombel
- Guru Kelas: Ada | Butuh | Kurang
- Guru Penjas: Ada | Butuh | Kurang
- Guru Agama: Ada | Butuh | Kurang
- Status Keseluruhan (LENGKAP / PARSIAL / KOSONG)

### 7.3 Laporan Riwayat Mutasi (`.xlsx`)

Filter: `tahun_ajaran`, `kecamatan`, `sekolah`, `formasi`. Kolom:
- No | Tanggal Efektif | Tahun Ajaran | Nama Guru | NIP | Formasi
- Dari Sekolah | Ke Sekolah | Keterangan | Diproses Oleh

---

## 8. Catatan Implementasi untuk Developer / AI Agent

### 8.1 Stack yang Direkomendasikan

| Layer | Pilihan Utama | Catatan |
|---|---|---|
| Backend | Laravel 10 / Node.js (Express) | Laravel direkomendasikan jika project sudah berbasis PHP |
| Frontend | Vue.js 3 / React / Blade + Alpine.js | Sesuaikan dengan stack yang sudah ada |
| Database | MySQL 8 / PostgreSQL | Gunakan transaction untuk proses mutasi |
| Laporan `.docx` | npm: `docx` | Sudah ada template referensi di proyek ini |
| Laporan `.xlsx` | npm: `xlsx` / PhpSpreadsheet | |
| Auth | Session / JWT / Sanctum | Semua endpoint API memerlukan autentikasi |

### 8.2 Prioritas Pengembangan

1. Buat tabel database sesuai skema di Bab 2 (migration)
2. Seed data `unit_kerja` (sekolah) dan `pegawai` dari data yang sudah ada
3. Implementasi query mapping (Bab 3.1) — ini yang paling sering dipanggil
4. Halaman daftar mapping + filter
5. Halaman detail sekolah + slot per formasi
6. Modal tarik guru + form konfirmasi mutasi
7. Proses mutasi (transaction — Bab 4.1)
8. Riwayat mutasi
9. Modul laporan `.docx`
10. Export rekap `.xlsx`

### 8.3 Poin Kritis yang Harus Diperhatikan

- **Proses mutasi WAJIB menggunakan database transaction.** Jika `UPDATE pegawai` gagal setelah `INSERT riwayat`, data akan inkonsisten.
- Query mapping menggunakan `LEFT JOIN` agar sekolah tanpa guru tetap muncul (jangan `INNER JOIN`).
- Filter formasi di modal assign harus ketat — jangan tampilkan guru penjas untuk slot guru kelas.
- `jumlah_rombel` di tabel `unit_kerja` harus selalu sinkron dengan jumlah baris aktif di tabel `rombel`, atau hitung langsung dari `COUNT` rombel.
- Indeks database yang diperlukan: `pegawai(unit_kerja_id)`, `pegawai(formasi_jabatan)`, `riwayat_mutasi(pegawai_id)`, `riwayat_mutasi(tahun_ajaran)`.

---

*Versi 1.0 · Juni 2025 · Dokumen untuk keperluan pengembangan sistem*
