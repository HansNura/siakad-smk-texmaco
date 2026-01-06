<?php ob_start(); ?>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-check-circle-fill me-2"></i> Validasi Nilai Siswa</h5>
                <small class="text-white-50">
                    <?php if ($isWaliKelas): ?>
                    Kelas Binaan: <?php echo htmlspecialchars($kelas["nama_kelas"]); ?>
                    <?php endif; ?>
                </small>
            </div>
            
            <div class="card-body">
                <?php showAlert(); ?>
                
                <?php if (empty($pending)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-clipboard-check display-4 mb-3 d-block"></i>
                        <p class="mb-0">Tidak ada pengajuan nilai yang perlu divalidasi saat ini.</p>
                    </div>
                <?php else: ?>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal Input</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru Pengampu</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pending as $row): ?>
                            <tr>
                                <td>
                                    <?php echo date("d M Y", strtotime($row["tgl_input"])); ?>
                                    <br>
                                    <small class="text-muted"><?php echo date("H:i", strtotime($row["tgl_input"])); ?> WIB</small>
                                </td>
                                <td>
                                    <span class="fw-bold text-primary"><?php echo htmlspecialchars($row["nama_mapel"]); ?></span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle text-center me-2" style="width:30px; height:30px; line-height:30px;">
                                            <i class="bi bi-person text-secondary"></i>
                                        </div>
                                        <?php echo htmlspecialchars($row["nama_guru"]); ?>
                                    </div>
                                </td>
                                <td><span class="badge bg-warning text-dark">Menunggu Validasi</span></td>
                                <td class="text-center">
                                    <a href="<?php echo BASE_URL; ?>/nilai/validasi/review?nilai_id=<?php echo $row["nilai_id"]; ?>"
                                        class="btn btn-sm btn-success">
                                        <i class="bi bi-eye-fill me-1"></i> Periksa & Validasi
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . "/../../layouts/main.php";
?>