**TUGAS: Implementasi Master Data Tahun Ajaran (Logic: Single Active Semester)**

**Konteks:**
Sistem membutuhkan pengaturan periode akademik (Tahun Ajaran & Semester). Aturan bisnis **KRUSIAL**: Hanya boleh ada **SATU** tahun ajaran yang statusnya `is_active = 1` pada satu waktu. Mengaktifkan satu periode harus otomatis menonaktifkan periode lainnya.

**Instruksi Eksekusi:**

1. **Database & Model (`app/models/TahunAjaran.php`):**

-   **SQL:** Eksekusi query berikut untuk reset/buat tabel:

```sql
DROP TABLE IF EXISTS `tahun_ajaran`;
CREATE TABLE `tahun_ajaran`  (
  `tahun_id` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` varchar(20) NOT NULL COMMENT 'Contoh: 2024/2025',
  `semester` enum('Ganjil','Genap') NOT NULL,
  `is_active` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`tahun_id`)
) ENGINE = InnoDB;

```

-   **Model Logic:**
-   Method `activateSemester($id)`: Gunakan Transaction.

1. `UPDATE tahun_ajaran SET is_active = 0` (Reset semua).
2. `UPDATE tahun_ajaran SET is_active = 1 WHERE tahun_id = :id` (Set yang dipilih).

-   Method `getActive()`: Ambil satu baris data dengan `WHERE is_active = 1`.

2. **Controller (`app/controllers/TahunAjaranController.php`):**

-   **Auth:** Pastikan hanya admin yang bisa akses.
-   **CRUD Standar:** `index`, `create`, `store`, `edit`, `update`, `destroy`.
-   **Method `activate($id)`:**
-   Panggil method `activateSemester($id)` di Model.
-   Redirect kembali ke index dengan Flash Message "Tahun Ajaran Aktif Berhasil Diubah".

3. **Views (`views/master/tahun_ajaran/`):**

-   **`index.php`:**
-   Tampilkan tabel: No, Tahun (2024/2025), Semester, Status, Aksi.
-   **Kolom Status:** Jika `is_active == 1`, tampilkan Badge Hijau "AKTIF". Jika `0`, tampilkan Badge Abu "Non-Aktif".
-   **Tombol Aksi:** Jika status "Non-Aktif", munculkan tombol/link "Aktifkan" yang mengarah ke route activate.

-   **`create.php` & `edit.php`:**
-   Input `tahun`: Text (Placeholder: 2024/2025).
-   Input `semester`: Select Option (Ganjil/Genap).

4. **Routing (`config/routes.php`):**

-   Daftarkan group route `/tahun-ajaran`.
-   Route khusus: `GET /tahun-ajaran/activate/{id}` (atau gunakan query string `/tahun-ajaran/activate?id=...` sesuai gaya router Anda).

=== CAKUPAN PEKERJAAN ===
Agent harus menyelesaikan:

1. **Database:** Eksekusi tabel `tahun_ajaran`.
2. **Model:** `app/models/TahunAjaran.php` (Fokus logic reset & set active).
3. **Controller:** `app/controllers/TahunAjaranController.php`.
4. **Views:** `views/master/tahun_ajaran/` (index, create, edit).
5. **Config:** Update `config/routes.php`.
