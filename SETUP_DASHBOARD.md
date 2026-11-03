# Setup Dashboard AdminLTE dengan Sidebar - siDia

## ✅ Apa yang Sudah Dilakukan

### 1. **Layout AdminLTE** 
   - File: `resources/views/layouts/admin.blade.php`
   - Fitur:
     - Sidebar dengan menu navigasi
     - Navbar dengan dropdown user menu
     - Footer
     - Brand/Logo siDia
     - User panel di sidebar
     - Responsive design

### 2. **Dashboard View**
   - File: `resources/views/dashboard.blade.php`
   - Menggunakan layout AdminLTE
   - Info box untuk statistik:
     - Total Pegawai
     - Departemen
     - Kehadiran Hari Ini
     - Cuti Menunggu
   - Welcome message

### 3. **Menu Sidebar**
   - Dashboard (home)
   - **Data Pegawai** (menu utama)
   - Profile (pengaturan)
   - Logout

### 4. **Data Pegawai Module**
   - **Controller**: `app/Http/Controllers/PegawaiController.php`
   - **Views**:
     - `resources/views/pegawai/index.blade.php` - Daftar pegawai
     - `resources/views/pegawai/create.blade.php` - Form tambah pegawai
     - `resources/views/pegawai/edit.blade.php` - Form edit pegawai
     - `resources/views/pegawai/show.blade.php` - Detail pegawai

### 5. **Route**
   - `/dashboard` - Dashboard utama
   - `/pegawai` - Daftar pegawai
   - `/pegawai/create` - Tambah pegawai
   - `/pegawai/{id}` - Lihat detail pegawai
   - `/pegawai/{id}/edit` - Edit pegawai
   - `DELETE /pegawai/{id}` - Hapus pegawai

### 6. **Konfigurasi AdminLTE**
   - File: `config/adminlte.php`
   - Menu items sudah dikonfigurasi
   - Sidebar styling: dark-primary

---

## 🚀 Cara Menggunakan

### 1. Login ke Aplikasi
```
Akses: http://localhost/dashboard (setelah login)
```

### 2. Navigasi ke Data Pegawai
```
Sidebar > MENU UTAMA > Data Pegawai
atau langsung ke: /pegawai
```

### 3. CRUD Data Pegawai
- **View** - Klik menu "Data Pegawai"
- **Create** - Klik tombol "Tambah Pegawai"
- **Update** - Klik tombol Edit (icon pensil)
- **Delete** - Klik tombol Hapus (icon trash)

---

## 📋 Field Data Pegawai

Saat ini sudah disediakan form dengan field:
- Nama Pegawai
- NIP
- Email
- Nomor Telepon
- Departemen
- Posisi/Jabatan
- Tanggal Bergabung

---

## 📝 TODO - Langkah Berikutnya

### Phase 1 - Database & Migration
- [ ] Buat migration untuk tabel `pegawai`
- [ ] Buat Model `Pegawai`
- [ ] Jalankan migration

### Phase 2 - Controller Logic
- [ ] Update PegawaiController dengan logic CRUD
- [ ] Add validation di request
- [ ] Add error handling

### Phase 3 - Features
- [ ] Add pencarian/filter data pegawai
- [ ] Add pagination
- [ ] Add export ke Excel/PDF
- [ ] Add foto/avatar pegawai

---

## 🎨 Customize

### Mengubah Warna Sidebar
Edit `config/adminlte.php`:
```php
'classes_sidebar' => 'sidebar-dark-primary elevation-4',
```

Opsi warna:
- `sidebar-dark-primary`
- `sidebar-dark-success`
- `sidebar-dark-warning`
- `sidebar-dark-danger`
- `sidebar-light-primary`
- dll

### Mengubah Logo/Brand
Edit `resources/views/layouts/admin.blade.php`:
```html
<span class="brand-text font-weight-light">siDia</span>
```

### Menambah Menu Baru
Edit `config/adminlte.php` di bagian `'menu'`:
```php
[
    'text' => 'Menu Baru',
    'url' => 'route-name',
    'icon' => 'fas fa-fw fa-icon-name',
],
```

---

## 📚 Resources

- AdminLTE Docs: https://adminlte.io/
- Laravel AdminLTE Package: https://github.com/jeroennoten/Laravel-AdminLTE
- Font Awesome Icons: https://fontawesome.com/icons

---

## ⚙️ Tech Stack

- **Laravel** - Framework
- **AdminLTE 3** - Dashboard Template
- **Bootstrap 4** - CSS Framework
- **jQuery** - JavaScript Library
- **Font Awesome** - Icons

---

Generated: 2024
