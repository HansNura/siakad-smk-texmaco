# Struktur Folder

### Struktur folder ini dirancang untuk memudahkan pengembangan web dengan pendekatan MVC (Model-View-Controller). Setiap komponen memiliki tujuan spesifik:

### Repository

https://github.com/HelgiNA/siakad-smk-texmaco.git

```
/siakad-texmaco/
├── app/
│   ├── Controllers/ # Logic pengatur alur (C)
│   │   ├── AuthController.php
│   │   ├── Controller.php
│   │   ├── HomeController.php
│   │   ├── UserController.php
│   │   └── ...
│   │
│   ├── Core/ # Base classes (Database Wrapper, Router, Middleware)
│   │   ├── Database.php
│   │   ├── Middleware.php
│   │   └── Route.php
│   │
│   └── Models/ # Interaksi Database (M)
│       ├── Model.php
│       ├── User.php
│       └── ...
│
├── config/
│   ├── config.php
│   └── routes.php
│
├── <?php echo BASE_URL ?>/public/
│   ├── assets
│   │   └── img/ # Assets gambar (AdminLTE, dll)
│   ├── css
│   └── js
│
├── views/                             <-- SEMUA TAMPILAN FRONTEND
│   │
│   ├── auth/                        <-- (SIA-001) HALAMAN LOGIN & AUTENTIKASI
│   │   └── login.php                <-- Halaman Login (Tanpa Sidebar/Navbar)
│   │
│   ├── dashboard/                   <-- (SIA-002) HALAMAN UTAMA SETELAH LOGIN
│   │   ├── index.php                <-- Dashboard Umum (Konten berubah sesuai Role)
│   │   ├── admin.php                <-- View khusus Admin (Summary Data, Statistik)
│   │   ├── guru.php                 <-- View khusus Guru (Kelas, Jadwal, Nilai)
│   │   └── siswa.php                <-- View khusus Siswa (Absensi, Nilai, Rapor)
│   │
│   ├── master/                      <-- (SIA-003) PENGELOLAAN DATA INDUK (ADMIN ONLY)
│   │   │
│   │   ├── siswa/
│   │   │   ├── index.php            <-- Tabel Daftar Siswa (List + Search + Filter)
│   │   │   ├── create.php           <-- Form Tambah Siswa (Validasi & Upload Foto)
│   │   │   ├── edit.php             <-- Form Edit Siswa (Update Data)
│   │   │   └── show.php             <-- Detail View Siswa (Profil Lengkap)
│   │   │
│   │   ├── guru/
│   │   │   ├── index.php            <-- Tabel Daftar Guru (List + Search + Filter)
│   │   │   ├── create.php           <-- Form Tambah Guru (Validasi & Upload Foto)
│   │   │   ├── edit.php             <-- Form Edit Guru (Update Data)
│   │   │   └── show.php             <-- Detail View Guru (Profil Lengkap)
│   │   │
│   │   ├── mapel/
│   │   │   ├── index.php            <-- Tabel Daftar Mata Pelajaran
│   │   │   ├── create.php           <-- Form Tambah Mapel
│   │   │   └── edit.php             <-- Form Edit Mapel
│   │   │
│   │   ├── kelas/
│   │   │   ├── index.php            <-- Tabel Daftar Kelas/Rombel
│   │   │   ├── create.php           <-- Form Tambah Kelas
│   │   │   └── edit.php             <-- Form Edit Kelas
│   │   │
│   │   └── tahun_ajaran/
│   │       ├── index.php            <-- Tabel Tahun Ajaran Aktif
│   │       ├── create.php           <-- Form Tambah Tahun Ajaran
│   │       └── edit.php             <-- Form Edit Tahun Ajaran
│   │
│   ├── akademik/                    <-- AREA OPERASIONAL (GURU & WALI KELAS)
│   │   │
│   │   ├── plotting/                <-- (SIA-000) PENEMPATAN SISWA KE KELAS
│   │   │   ├── index.php            <-- List Rombel & Siswa yang sudah di-plot
│   │   │   ├── manage.php           <-- Kelola Penempatan Siswa ke Rombel
│   │   │   └── add.php              <-- Tambahkan/Pindahkan Siswa ke Rombel
│   │   │
│   │   ├── absensi/
│   │   │   ├── index.php            <-- List Absensi (View & Export)
│   │   │   ├── create.php           <-- Input Absensi (SIA-004) Guru input absen
│   │   │   ├── validationList.php   <-- (SIA-005) Wali Kelas validasi absen
│   │   │   └── validationReview.php <-- Review & Konfirmasi Validasi Absensi
│   │   │
│   │   ├── nilai/
│   │   │   ├── index.php            <-- List Nilai (View & Export)
│   │   │   ├── create.php           <-- Input Nilai (SIA-006) Guru input nilai
│   │   │   ├── validationList.php   <-- (SIA-008) Wali Kelas validasi nilai
│   │   │   └── validationReview.php <-- Review & Konfirmasi Validasi Nilai
│   │   │
│   │   └── rapor/
│   │       ├── index.php            <-- List Rapor & Preview
│   │       ├── cetak.php            <-- (SIA-010) Template Cetak PDF Rapor
│   │       └── input_catatan.php    <-- Input Catatan untuk Rapor (Wali Kelas)
│   │
│   ├── validasi/                    <-- HALAMAN KHUSUS VALIDASI DATA
│   │   └── nilai.php                <-- Validasi Nilai (Alternative View)
│   │
│   ├── siswa/                       <-- VIEW KHUSUS SISWA
│   │   └── profil.php               <-- Profil Siswa (Personal Data & Contact)
│   │
│   ├── users/                       <-- (SIA-011) MANAJEMEN AKUN & USER (ADMIN)
│   │   ├── index.php                <-- Daftar User (Admin Panel)
│   │   ├── create.php               <-- Form Tambah User Baru
│   │   └── edit.php                 <-- Form Edit User
│   │
│   ├── layouts/                     <-- PONDASI UTAMA (MASTER TEMPLATE)
│   │   ├── main.php                 <-- Template Dashboard (Sidebar + Navbar + Content)
│   │   └── auth.php                 <-- Template Polos untuk Login (Tanpa Sidebar)
│   │
│   ├── errors/                      <-- HALAMAN ERROR
│   │   ├── 403.php                  <-- Forbidden (Akses Ditolak)
│   │   └── 404.php                  <-- Not Found (Halaman Tidak Ditemukan)
│   │
│   └── partials/                    <-- POTONGAN KODE (RE-USABLE COMPONENTS)
│       ├── sidebar.php              <-- Menu Samping (Logic Role ada di sini)
│       ├── navbar.php               <-- Bar Atas (Profil & Logout & Notifikasi)
│       ├── footer.php               <-- Footer (Copyright & Info)
│       ├── flash.php                <-- Alert Sukses/Gagal/Info (Penting!)
│       └── alert.php                <-- Component Alert Modal
│
├── create_admin.php
├── db_siakad_texmaco.sql
├── index.php
└── struktur_folder.md
```
