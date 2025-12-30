# Struktur Folder

### Struktur folder ini dirancang untuk memudahkan pengembangan web dengan pendekatan MVC (Model-View-Controller). Setiap komponen memiliki tujuan spesifik:

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
├── views/
│   ├── auth/                   <-- (SIA-001) Login Area
│   │   └── login.php           <-- Halaman Login (Tanpa Sidebar/Navbar)
│   │
│   ├── dashboard/              <-- (SIA-002) Halaman Utama setelah Login
│   │   └── index.php           <-- Dashboard (Konten berubah sesuai Role)
│   │
│   ├── master/                 <-- (SIA-003) Pengelolaan Data Induk (Admin Only)
│   │   ├── siswa/
│   │   │   ├── index.php       <-- Tabel Daftar Siswa
│   │   │   ├── create.php      <-- Form Tambah Siswa
│   │   │   └── edit.php        <-- Form Edit Siswa
│   │   │
│   │   ├── guru/
│   │   │   ├── index.php
│   │   │   ├── create.php
│   │   │   └── edit.php
│   │   │
│   │   ├── mapel/
│   │   │   ├── index.php
│   │   │   └── ...
│   │   │
│   │   └── kelas/
│   │       ├── index.php
│   │       └── ...
│   │
│   ├── akademik/               <-- Area Operasional (Guru & Wali Kelas)
│   │   ├── absensi/
│   │   │   ├── input.php       <-- (SIA-004) Guru input absen
│   │   │   └── validasi.php    <-- (SIA-005) Wali Kelas validasi absen
│   │   │
│   │   ├── nilai/
│   │   │   ├── input.php       <-- (SIA-006) Guru input nilai
│   │   │   ├── validasi.php    <-- (SIA-008) Wali Kelas validasi nilai
│   │   │   └── detail.php      <-- (SIA-009) Siswa lihat nilai sendiri
│   │   │
│   │   └── rapor/
│   │       └── cetak.php       <-- (SIA-010) Template Cetak PDF
│   │
│   ├── users/                  <-- (SIA-011) Manajemen Akun (Admin)
│   │   ├── index.php
│   │   └── create.php
│   │
│   ├── layouts/                <-- PONDASI UTAMA (Master Template)
│   │   ├── main.php            <-- Template Dashboard (Sidebar + Navbar + Content)
│   │   └── auth.php            <-- Template Polos untuk Login
│   │
│   └── partials/               <-- Potongan Kode (Re-usable components)
│       ├── sidebar.php         <-- Menu Samping (Logic Role ada di sini)
│       ├── navbar.php          <-- Bar Atas (Profil & Logout)
│       ├── footer.php
│       └── flash.php           <-- Alert Sukses/Gagal (Penting!)
│
├── create_admin.php
├── db_siakad_texmaco.sql
├── index.php
└── struktur_folder.md
```
