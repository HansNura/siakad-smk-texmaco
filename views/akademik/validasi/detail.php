<?php
    ob_start();
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 text-primary fw-bold">Detail Validasi Absensi</h4>
        <p class="text-muted mb-0">ID: <?php echo $absensi['absensi_id'] ?> | Status: <span
                class="badge bg-warning text-dark"><?php echo $absensi['status_validasi'] ?></span></p>
    </div>
    <a href="<?php echo BASE_URL ?>/validasi" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-light fw-bold">Informasi Jadwal</div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <th width="100">Hari, Tanggal</th>
                        <td>: <?php echo $absensi['hari'] ?>,<?php echo date('d M Y', strtotime($absensi['tanggal'])) ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Jam</th>
                        <td>: <?php echo date('H:i', strtotime($absensi['jam_mulai'])) ?>
                            -<?php echo date('H:i', strtotime($absensi['jam_selesai'])) ?></td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>: <?php echo htmlspecialchars($absensi['nama_kelas']) ?></td>
                    </tr>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <td>: <?php echo htmlspecialchars($absensi['nama_mapel']) ?></td>
                    </tr>
                    <tr>
                        <th>Guru</th>
                        <td>: <?php echo htmlspecialchars($absensi['nama_guru']) ?></td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td>: <em><?php echo nl2br(htmlspecialchars($absensi['catatan_harian'] ?? '-')) ?></em></td>
                    </tr>
                </table>
            </div>
            <div class="card-footer bg-white">
                <form action="<?php echo BASE_URL ?>/validasi/approve" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin memvalidasi data ini?');">
                    <input type="hidden" name="absensi_id" value="<?php echo $absensi['absensi_id'] ?>">
                    <div class="d-grid gap-2">
                        <button type="submit" name="action" value="approve" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i> Validasi (Setujui)
                        </button>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                            data-bs-target="#rejectModal">
                            <i class="bi bi-x-circle me-1"></i> Tolak (Revisi)
                        </button>
                    </div>

                    <!-- Modal Reject -->
                    <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tolak Pengajuan Absensi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menolak absensi ini? Guru akan diminta untuk merevisi.
                                    </p>
                                    <div class="mb-3">
                                        <label for="alasan_penolakan" class="form-label fw-bold">Alasan Penolakan <span
                                                class="text-danger">*</span></label>
                                        <textarea name="alasan_penolakan" id="alasan_penolakan" class="form-control"
                                            rows="3"
                                            placeholder="Contoh: Siswa atas nama Budi sakit tapi tertulis alpa."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" name="action" value="reject" class="btn btn-danger">Ya, Tolak
                                        Absensi</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-light fw-bold">Detail Kehadiran Siswa</div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover table-striped mb-0 align-middle">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th class="px-3">No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($details as $idx => $row): ?>
                            <tr>
                                <td class="px-3"><?php echo $idx + 1 ?></td>
                                <td><?php echo htmlspecialchars($row['nis']) ?></td>
                                <td><?php echo htmlspecialchars($row['nama_lengkap']) ?></td>
                                <td class="text-center">
                                    <?php
                                        $badge = 'bg-secondary';
                                        if ($row['status_kehadiran'] === 'Hadir') {
                                            $badge = 'bg-success';
                                        } elseif ($row['status_kehadiran'] === 'Sakit') {
                                            $badge = 'bg-warning text-dark';
                                        } elseif ($row['status_kehadiran'] === 'Izin') {
                                            $badge = 'bg-info text-dark';
                                        } elseif ($row['status_kehadiran'] === 'Alpa') {
                                            $badge = 'bg-danger';
                                        }

                                    ?>
                                    <span
                                        class="badge<?php echo $badge ?> rounded-pill px-3"><?php echo $row['status_kehadiran'] ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
    $content = ob_get_clean();
require_once __DIR__ . '/../../layouts/main.php';
?>