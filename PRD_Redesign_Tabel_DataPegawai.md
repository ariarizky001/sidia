Error
resources\views\master-data\formasi-jabatan\edit.blade.php:97
Call to a member function format() on null# PRODUCT REQUIREMENTS DOCUMENT
## Redesign Tabel Data Pegawai
### Menuju Tampilan Minimalis & Modern

> **Versi 1.0  •  Dinas Pendidikan  •  Sistem Informasi ASN  •  Juni 2026**

---

## 1. Ringkasan Eksekutif

Dokumen ini mendefinisikan kebutuhan perancangan ulang (redesign) komponen tabel Data Pegawai pada sistem informasi kepegawaian. Perubahan bertujuan mengubah tampilan tabel dari desain lama yang penuh elemen visual berat menjadi tampilan minimalis, bersih, dan profesional yang mengacu pada referensi UI modern.

**Tujuan utama:** Meningkatkan keterbacaan data, mengurangi kekacauan visual (visual clutter), dan mempercepat pemindaian informasi oleh pengguna.

---

## 2. Analisis Kondisi Saat Ini (As-Is)

Tabel Data Pegawai saat ini memiliki karakteristik berikut:

- Kolom sangat banyak: No., Foto, NIP, Nama Pegawai, Tempat/Tanggal Lahir, L/P, Agama, Alamat, No. HP, dan kolom Aksi — total **10 kolom**
- Kolom foto menggunakan avatar bergambar besar yang memakan ruang horizontal signifikan
- Header tabel menggunakan ikon sort (↑↓) pada setiap kolom, terasa ramai
- Tipografi pada NIP berwarna biru sebagai hyperlink namun tidak ada tujuan navigasi yang jelas
- Tombol aksi berupa ikon berwarna (kuning edit, merah hapus) dengan border — mencolok secara visual
- Pagination menggunakan gaya tombol angka bulat berwarna teal yang kontras berlebihan
- Tampilan data tanggal lahir digabung dengan tempat lahir dalam satu kolom panjang
- Terlalu banyak informasi tampil sekaligus tanpa hirarki visual yang jelas

---

## 3. Target Desain (To-Be)

Mengacu pada referensi tabel yang diberikan, target desain memiliki karakteristik:

- Tabel bersih tanpa border berat — hanya garis horizontal tipis antar baris
- Kolom dikurangi menjadi informasi paling esensial: NIP, Nama Lengkap, Status ASN, Golongan, Jabatan, Status Aktif, dan Aksi
- NIP tetap berwarna biru sebagai identifier utama yang clickable untuk melihat detail
- Nama pegawai ditampilkan tebal (bold) dengan tanggal lahir sebagai teks abu kecil di bawahnya — informasi berlapis dalam satu sel
- Status ditampilkan sebagai badge/chip berwarna (hijau untuk Aktif, abu untuk non-aktif) — visual feedback cepat
- Tombol aksi minimalis: ikon kecil dalam kotak outline tanpa warna latar — eye (lihat), edit (kuning outline), hapus (merah outline)
- Tidak ada foto avatar — dihapus untuk efisiensi ruang
- Gaya font konsisten: satu ukuran untuk data utama, satu ukuran lebih kecil untuk data sekunder

---

## 4. Perbandingan Fitur: Sebelum vs Sesudah

| Aspek | Kondisi Saat Ini | Target Redesign |
|---|---|---|
| Jumlah kolom | 10 kolom | 7 kolom |
| Kolom foto/avatar | Ada — bergambar besar | Dihapus |
| Kolom T/TGL Lahir | Satu kolom panjang teks | Dua baris dalam kolom Nama |
| Kolom Agama | Tampil eksplisit | Dipindah ke halaman detail |
| Kolom Alamat | Tampil eksplisit | Dipindah ke halaman detail |
| Kolom No. HP | Tampil eksplisit | Dipindah ke halaman detail |
| Status pegawai | Tidak ada | Kolom baru: Status Aktif (badge) |
| Golongan | Tidak ada | Kolom baru: Golongan |
| Jabatan | Tidak ada | Kolom baru: Jabatan |
| Tombol aksi | 2 tombol ikon warna solid | 3 tombol ikon outline minimal |
| Header sort | Ikon ↑↓ di setiap kolom | Hanya kolom yang bisa di-sort |
| Border tabel | Border grid penuh | Hanya garis horizontal tipis |
| Pagination | Tombol bulat teal tebal | Tombol teks minimal, angka saja |
| Density informasi | Semua data tampil sekaligus | Data kritis tampil, detail di modal/halaman baru |

---

## 5. Spesifikasi Kolom Baru

| Kolom | Tipe Data | Tampilan | Keterangan |
|---|---|---|---|
| NIP | String (18 digit) | Teks biru, clickable → detail | Identifier utama pegawai |
| Nama Lengkap | String + Date | Nama bold, tgl lahir abu kecil | Dua baris dalam satu sel |
| Status ASN | Enum (PNS/PPPK/Non-ASN) | Badge chip berwarna | Warna: teal=PNS, biru=PPPK |
| Golongan | String (I/a s.d IV/e) | Teks biasa | Dari data kepangkatan |
| Jabatan | String | Teks uppercase | Jabatan/formasi aktif |
| Status Aktif | Boolean | Badge: Aktif (hijau) / Non-aktif (abu) | Status keaktifan pegawai |
| Aksi | — | 3 ikon: 👁 ✏ 🗑 | Detail, Edit, Hapus |

---

## 6. Spesifikasi Visual & Desain

### 6.1 Tipografi

| Elemen | Spesifikasi |
|---|---|
| NIP | font-size 14px, warna `#3B82F6` (biru), font-weight 400, underline on hover |
| Nama pegawai | font-size 14px, font-weight 600 (semibold), warna `#111827` |
| Tanggal lahir (sub-baris) | font-size 12px, font-weight 400, warna `#9CA3AF` |
| Data umum (golongan, jabatan) | font-size 14px, font-weight 400, warna `#374151` |
| Header kolom | font-size 13px, font-weight 700, warna `#334155`, uppercase |

### 6.2 Warna & Badge

| Badge | Warna Background | Teks | Border Radius |
|---|---|---|---|
| PNS | `#0D9488` (teal-600) | Putih | 4px, padding 2px 8px |
| PPPK | `#2563EB` (biru-600) | Putih | 4px |
| Aktif | `#16A34A` (hijau-600) | Putih | 4px |
| Non-Aktif | `#6B7280` (abu-500) | Putih | 4px |
| Header tabel | `#F8FAFC` | — | — |
| Divider baris | `border-bottom: 1px solid #E2E8F0` | — | — |
| Hover baris | `#F8FAFC` | — | — |

### 6.3 Tombol Aksi

| Tombol | Border | Ikon | Hover |
|---|---|---|---|
| Detail (👁) | `1px solid #93C5FD` | Biru | bg biru terang |
| Edit (✏) | `1px solid #FCD34D` | Amber/kuning | bg kuning terang |
| Hapus (🗑) | `1px solid #FCA5A5` | Merah | bg merah terang |

> **Ukuran tombol:** 28×28px, border-radius 6px, ikon 14px, background transparan

### 6.4 Tabel

| Properti | Nilai |
|---|---|
| Border tabel | Tidak ada border luar — hanya garis horizontal antar baris |
| Padding sel | `padding: 14px 16px` |
| Tinggi baris | min-height 64px |
| Alignment | Semua teks rata kiri; kolom Aksi rata kanan |

---

## 7. Spesifikasi Perilaku Interaktif

### 7.1 Sorting

- Kolom yang bisa di-sort: NIP, Nama Lengkap, Golongan, Jabatan
- Kolom yang tidak bisa di-sort: Status ASN, Status Aktif, Aksi
- Indikator sort: ikon panah kecil muncul hanya di kolom yang aktif di-sort
- Default sort: Nama Lengkap A-Z

### 7.2 Pencarian

- Search bar tetap ada di kanan atas tabel
- Placeholder: `Cari nama atau NIP...`
- Pencarian real-time (debounce 300ms) — tidak perlu tekan Enter
- Jika tidak ada hasil: tampilkan ilustrasi kosong dengan teks *"Tidak ada data pegawai yang sesuai pencarian"*

### 7.3 Tombol Aksi

- **Tombol Detail:** membuka modal atau halaman baru dengan data lengkap pegawai termasuk foto, alamat, agama, kontak
- **Tombol Edit:** membuka form edit pegawai (halaman atau modal)
- **Tombol Hapus:** memunculkan dialog konfirmasi sebelum menghapus data

### 7.4 Pagination

- Format: `< 1  2  3  ...  50  >` — teks minimal, tidak ada warna solid
- Halaman aktif: teks bold atau underline, bukan tombol warna solid
- Info count: *"Menampilkan 1-10 dari 500 data"* di bawah kiri tabel
- Pilihan jumlah data per halaman: dropdown kecil 10 / 25 / 50

### 7.5 Responsivitas

| Prioritas | Kolom | Breakpoint |
|---|---|---|
| Tinggi — selalu tampil | NIP, Nama Lengkap, Status Aktif, Aksi | Semua ukuran |
| Sedang — disembunyikan | Golongan, Jabatan | Tablet < 768px |
| Rendah — disembunyikan | Status ASN | Mobile < 480px |

---

## 8. Alur Data & Integrasi

Perubahan ini bersifat **front-end only**. Tidak ada perubahan pada struktur database atau API. Data yang saat ini tidak ditampilkan di tabel (alamat, agama, no. HP, foto) tetap tersedia melalui endpoint detail pegawai dan ditampilkan saat pengguna membuka halaman/modal detail.

### 8.1 Endpoint yang Digunakan

```
GET  /api/pegawai?page={n}&limit={limit}&search={q}&sort={col}&dir={asc|desc}
GET  /api/pegawai/{nip}
PUT  /api/pegawai/{nip}
DELETE /api/pegawai/{nip}
```

### 8.2 Format Response untuk List Tabel

Field minimal yang harus ada dalam list response:

```json
{
  "nip": "197812222010012009",
  "nama_lengkap": "DEASY ARI ANAWATI, S.E.",
  "tanggal_lahir": "1978-12-22",
  "status_asn": "PNS",
  "golongan": "III/d",
  "jabatan": "PENGOLAH DATA DAN INFORMASI",
  "is_aktif": true
}
```

> Field lain (foto, alamat, agama, no_hp) boleh tidak disertakan dalam list response untuk menghemat payload.

---

## 9. Kriteria Penerimaan (Acceptance Criteria)

1. Tabel menampilkan tepat 7 kolom sesuai spesifikasi Bagian 5
2. Kolom Nama Lengkap menampilkan dua baris: nama bold di atas, tanggal lahir abu di bawah
3. Semua badge (PNS, PPPK, Aktif, Non-Aktif) tampil dengan warna yang sesuai spesifikasi
4. Tidak ada border vertikal atau border luar pada tabel — hanya divider horizontal
5. Tombol aksi menggunakan outline tanpa latar warna solid
6. Baris ke-3 pada tabel sampel menampilkan highlight berbeda (zebra subtle atau hover state) sebagaimana referensi
7. Tombol Hapus memunculkan dialog konfirmasi sebelum eksekusi
8. Pagination menggunakan gaya teks minimal tanpa tombol warna solid
9. Foto avatar dihapus sepenuhnya dari tampilan tabel
10. Tampilan tetap dapat digunakan di layar 1024px ke atas tanpa horizontal scroll

---

## 10. Di Luar Cakupan (Out of Scope)

- Perubahan struktur database atau schema tabel
- Perubahan API endpoint yang sudah ada
- Redesign halaman form Tambah/Edit Pegawai
- Perubahan fitur export Excel dan cetak
- Redesign navigasi atau sidebar

---

## 11. Prioritas Implementasi

| # | Perubahan | Prioritas | Estimasi |
|---|---|---|---|
| 1 | Hapus kolom Foto, Agama, Alamat, No. HP dari tabel | 🔴 Tinggi | 0.5 hari |
| 2 | Tambah kolom Status ASN, Golongan, Jabatan, Status Aktif | 🔴 Tinggi | 1 hari |
| 3 | Kolom Nama: nama bold + sub-baris tanggal lahir | 🔴 Tinggi | 0.5 hari |
| 4 | Badge chip untuk Status ASN dan Status Aktif | 🔴 Tinggi | 0.5 hari |
| 5 | Ubah tombol aksi menjadi outline minimal + tambah tombol detail | 🔴 Tinggi | 0.5 hari |
| 6 | Hapus border vertikal tabel | 🟡 Sedang | 0.5 hari |
| 7 | Redesign pagination menjadi teks minimal | 🟡 Sedang | 0.5 hari |
| 8 | Zebra row / hover state subtle | 🟢 Rendah | 0.5 hari |
| 9 | Responsivitas mobile (sembunyikan kolom prioritas rendah) | 🟢 Rendah | 1 hari |

**Total estimasi:** ~5.5 hari kerja

---

*PRD ini dibuat sebagai panduan implementasi redesign tabel Data Pegawai — versi 1.0 — Juni 2026*
