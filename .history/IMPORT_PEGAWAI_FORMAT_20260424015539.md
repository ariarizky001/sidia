# Panduan Format Excel Import Pegawai

## ✅ Format Header yang BENAR

**GUNAKAN COMMA (,) SEBAGAI PEMISAH KONSISTEN:**

```
NIP,NAMA_LENGKAP,TGL_LAHIR,GOL,TMT_GOL,JABATAN,TMT_JABATAN,ESL,TMT_CPNS,PENDIDIKAN,THN_LULUS,STATUS_ASN,FORMASI_JABATAN,UNIT_KERJA_1,UNIT_KERJA_2,UNIT_KERJA_3
```

## ❌ Format SALAH (seperti Excel Anda saat ini)

```
NIP,NAMA_LENGKAP,TGL_LAHIR,GOL,TMT_GOL	JABATAN,TMT_JABATAN,ESL,TMT_CPNS,PENDIDIKAN,THN_LULUS,STATUS_ASN,FORMASI_JABATAN,UNIT_KERJA_1,UNIT_KERJA_2	UNIT_KERJA_3
                                    ^                                                                       ^
                        TAB character (SALAH)                                                TAB character (SALAH)
```

---

## 📋 Penjelasan Setiap Kolom

| Kolom | Tipe | Wajib | Keterangan | Contoh |
|-------|------|-------|-----------|--------|
| **NIP** | Angka | Ya | Nomor Identitas Pegawai - HARUS UNIK | 197806151999031001 |
| **NAMA_LENGKAP** | Text | Ya | Nama lengkap pegawai | JOKO SUSILO |
| **TGL_LAHIR** | Tanggal | Tidak | Format: DD-MM-YYYY atau DD/MM/YYYY | 15-06-1978 |
| **GOL** | Text | Tidak | Golongan (dari master golongan) | III/d |
| **TMT_GOL** | Tanggal | Tidak | Tanggal Mulai Tugas Golongan | 01-04-2020 |
| **JABATAN** | Text | Tidak | Nama Jabatan (dari master jabatan) | KEPALA DINAS |
| **TMT_JABATAN** | Tanggal | Tidak | Tanggal Mulai Tugas Jabatan | 01-01-2021 |
| **ESL** | Text | Tidak | Eselon (dari master eselon) | II.a |
| **TMT_CPNS** | Tanggal | Tidak | Tanggal Mulai Tugas CPNS | 01-06-2000 |
| **PENDIDIKAN** | Text | Tidak | Jenjang Pendidikan (S1, S2, SMA, dll) | S1 |
| **THN_LULUS** | Angka | Tidak | Tahun Lulus | 2000 |
| **STATUS_ASN** | Text | Tidak | Status ASN (dari master status asn) | PNS |
| **FORMASI_JABATAN** | Text | Tidak | Formasi Jabatan | Kepala |
| **UNIT_KERJA_1** | Text | Tidak | Unit Kerja Utama | DINAS PENDIDIKAN |
| **UNIT_KERJA_2** | Text | Tidak | Unit Kerja Kedua (opsional) | - |
| **UNIT_KERJA_3** | Text | Tidak | Unit Kerja Ketiga (opsional) | - |

---

## 🔍 Troubleshooting: Data Menjadi NULL

Jika field `golongan_id`, `jabatan_id`, `eselon_id`, dll menjadi NULL di database, ini berarti:

### Penyebab 1: Data tidak cocok dengan Master Data
**Solusi:** Pastikan nilai di Excel **SAMA PERSIS** dengan data di master:

```sql
-- Cek Golongan yang tersedia
SELECT kode FROM golongans;

-- Cek Jabatan yang tersedia
SELECT nama_jabatan FROM jabatans;

-- Cek Eselon yang tersedia
SELECT kode, nama_eselon FROM eselons;

-- Cek Status ASN
SELECT kode, nama FROM status_asns;

-- Cek Jenjang Pendidikan
SELECT kode, nama_jenjang FROM jenjang_pendidikans;

-- Cek Unit Kerja
SELECT nama FROM unit_kerjas;
```

### Penyebab 2: Format Tanggal Salah
**Gunakan format:** `DD-MM-YYYY` atau `DD/MM/YYYY` atau biarkan kosong

Jangan gunakan format lain seperti `YYYY-MM-DD` atau teks lain.

### Penyebab 3: Spasi atau Karakter Aneh
**Bersihkan data:**
- Hilangkan spasi di awal/akhir
- Jangan gunakan spasi ekstra di tengah
- Gunakan UPPERCASE (GOL, bukan gol atau Gol)

---

## 📥 Contoh File Excel yang Benar

```csv
NIP,NAMA_LENGKAP,TGL_LAHIR,GOL,TMT_GOL,JABATAN,TMT_JABATAN,ESL,TMT_CPNS,PENDIDIKAN,THN_LULUS,STATUS_ASN,FORMASI_JABATAN,UNIT_KERJA_1,UNIT_KERJA_2,UNIT_KERJA_3
197806151999031001,JOKO SUSILO,15-06-1978,III/d,01-04-2020,KEPALA DINAS,01-01-2021,II.a,01-06-2000,S1,2000,PNS,Kepala,DINAS PENDIDIKAN,,
198905201998022001,SITI NURHALIZA,20-05-1989,II/c,01-03-2019,SEKRETARIS,01-06-2019,III.b,01-08-2008,S1,2008,PNS,Staf,DINAS KESEHATAN,,
197203101996031002,BUDI SANTOSO,10-03-1972,IV/a,01-01-2022,DIREKTUR,01-01-2022,I.b,01-01-1996,S2,1996,PNS,Pimpinan,DINAS LINGKUNGAN,,
```

---

## 📝 Cara Melihat Log Import

Setelah import, lihat log untuk debug:

```bash
tail -f storage/logs/laravel.log
```

Cari log dengan `Excel Header Keys Found` dan `Lookup Results` untuk melihat:
- Header yang diterima sistem
- Nilai yang di-lookup
- ID yang ditemukan (atau NULL jika tidak ketemu)

---

## 🚀 Langkah Import yang Benar

1. **Perbaiki format Excel** → Pastikan header pakai COMMA (,)
2. **Sesuaikan nilai** → Pastikan data cocok dengan master data
3. **Bersihkan spasi** → Gunakan TRIM untuk hilangkan spasi ekstra
4. **Upload file**
5. **Cek log** → Lihat apakah lookup berhasil
6. **Verifikasi data** → Query database untuk pastikan ID terisi

---

## ❓ FAQ

**Q: Bisa pakai format YYYY-MM-DD untuk tanggal?**
A: Bisa, tapi lebih baik gunakan DD-MM-YYYY karena itu format standar Indonesia.

**Q: Semua field wajib diisi?**
A: Tidak, hanya NIP dan NAMA_LENGKAP yang wajib. Field lain boleh kosong.

**Q: Bagaimana jika master data belum ada?**
A: Anda harus membuat master data terlebih dahulu via menu master (Golongan, Jabatan, Eselon, dll).

**Q: Bisa import ulang data yang sudah ada?**
A: Tidak, NIP harus UNIK. Jika ingin update, gunakan menu edit per record.

---

**Kontribusi:** Gunakan dokumentasi ini sebagai checklist sebelum import!
