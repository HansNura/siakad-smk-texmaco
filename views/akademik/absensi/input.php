<?php
    ob_start();
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 text-primary fw-bold">Input Absensi</h4>
        <p class="text-muted mb-0">
            <?php echo htmlspecialchars($jadwal['nama_kelas']) ?> |<?php echo htmlspecialchars($jadwal['nama_mapel']) ?>
        </p>
    </div>
    <a href="<?php echo BASE_URL ?>/absensi/create" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <?php if (isset($absensi) && $absensi['status_validasi'] === 'Rejected'): ?>
        <div class="alert alert-danger">
            <strong><i class="bi bi-exclamation-octagon-fill me-2"></i> PERHATIAN!</strong> Data ini DITOLAK oleh Wali
            Kelas.<br>
            Alasan: <?php echo htmlspecialchars($absensi['alasan_penolakan']) ?>
        </div>
        <?php endif; ?>

        <form action="<?php echo BASE_URL ?>/absensi/store" method="POST">
            <input type="hidden" name="jadwal_id" value="<?php echo $jadwal['jadwal_id'] ?>">
            <input type="hidden" name="tanggal" value="<?php echo $tanggal ?>">

            <div class="mb-4">
                <label for="catatan" class="form-label fw-bold">Catatan Harian (Jurnal)</label>
                <textarea name="catatan_harian" id="catatan" class="form-control" rows="2"
                    placeholder="Materi yang diajarkan, kejadian khusus, dll..."
                    required><?php echo htmlspecialchars($jadwal['catatan_harian_value'] ?? '') ?></textarea>
            </div>

            <div class="table-responsive mb-4">
                <table class="table table-hover align-middle">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th width="50">No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th class="text-center">Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($siswa as $idx => $s):
                                $savedStatus = $savedDetails[$s['siswa_id']] ?? 'Hadir';
                            ?>
                        <tr>
                            <td><?php echo $idx + 1 ?></td>
                            <td><?php echo htmlspecialchars($s['nis']) ?></td>
                            <td class="fw-bold"><?php echo htmlspecialchars($s['nama_lengkap']) ?></td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Status Kehadiran">

                                    <input type="radio" class="btn-check"
                                        name="status_kehadiran[<?php echo $s['siswa_id'] ?>]"
                                        id="hadir_<?php echo $s['siswa_id'] ?>" value="Hadir"
                                        <?php echo $savedStatus === 'Hadir' ? 'checked' : '' ?>>
                                    <label class="btn btn-outline-success"
                                        for="hadir_<?php echo $s['siswa_id'] ?>">H</label>

                                    <input type="radio" class="btn-check"
                                        name="status_kehadiran[<?php echo $s['siswa_id'] ?>]"
                                        id="sakit_<?php echo $s['siswa_id'] ?>" value="Sakit"
                                        <?php echo $savedStatus === 'Sakit' ? 'checked' : '' ?>>
                                    <label class="btn btn-outline-warning"
                                        for="sakit_<?php echo $s['siswa_id'] ?>">S</label>

                                    <input type="radio" class="btn-check"
                                        name="status_kehadiran[<?php echo $s['siswa_id'] ?>]"
                                        id="izin_<?php echo $s['siswa_id'] ?>" value="Izin"
                                        <?php echo $savedStatus === 'Izin' ? 'checked' : '' ?>>
                                    <label class="btn btn-outline-info"
                                        for="izin_<?php echo $s['siswa_id'] ?>">I</label>

                                    <input type="radio" class="btn-check"
                                        name="status_kehadiran[<?php echo $s['siswa_id'] ?>]"
                                        id="alpa_<?php echo $s['siswa_id'] ?>" value="Alpa"
                                        <?php echo $savedStatus === 'Alpa' ? 'checked' : '' ?>>
                                    <label class="btn btn-outline-danger"
                                        for="alpa_<?php echo $s['siswa_id'] ?>">A</label>

                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Simpan Absensi
                </button>
            </div>
        </form>
    </div>
</div>


<?php
    $content = ob_get_clean();
require_once __DIR__ . '/../../layouts/main.php';
?>