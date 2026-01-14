<?php ob_start(); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fw-bold">
                        <i class="fas fa-print me-2"></i> Cetak Rapor Siswa
                    </h3>
                    <?php if(isset($kelas)): ?>
                        <span class="badge bg-primary fs-6">
                            Kelas: <?php echo htmlspecialchars($kelas['nama_kelas']); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="card-body">
                    <?php showAlert(); ?>

                    <?php if (empty($list)): ?>
                        <div class="alert alert-warning">
                            Anda belum terdaftar sebagai Wali Kelas atau belum ada siswa di kelas Anda.
                        </div>
                    <?php else: ?>
                        
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:5%">No</th>
                                        <th style="width:15%">NIS</th>
                                        <th>Nama Siswa</th>
                                        <th style="width:15%">Status Catatan</th>
                                        <th style="width:20%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($list as $item): 
                                        $s = $item['siswa'];
                                        $status = $item['status_catatan']; // 'Sudah Diisi' atau 'Belum Diisi'
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($s['nis']); ?></td>
                                        <td class="fw-bold"><?php echo htmlspecialchars($s['nama_lengkap']); ?></td>
                                        <td>
                                            <?php if ($status === 'Sudah Diisi'): ?>
                                                <span class="badge bg-success"><i class="fas fa-check me-1"></i> Lengkap</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger"><i class="fas fa-exclamation-circle me-1"></i> Belum Diisi</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo BASE_URL; ?>/rapor/catatan?id=<?php echo $s['siswa_id']; ?>" 
                                                   class="btn btn-sm btn-warning text-dark" 
                                                   title="Input Catatan Wali Kelas">
                                                    <i class="fas fa-pen-nib"></i> Catatan
                                                </a>

                                                <?php if ($status === 'Sudah Diisi'): ?>
                                                    <a href="<?php echo BASE_URL; ?>/rapor/print?id=<?php echo $s['siswa_id']; ?>" 
                                                       target="_blank"
                                                       class="btn btn-sm btn-primary"
                                                       title="Cetak Rapor">
                                                        <i class="fas fa-print"></i> Cetak
                                                    </a>
                                                <?php else: ?>
                                                    <button class="btn btn-sm btn-secondary" disabled title="Isi catatan terlebih dahulu">
                                                        <i class="fas fa-print"></i> Cetak
                                                    </button>
                                                <?php endif; ?>
                                            </div>
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
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . "/../../layouts/main.php";
?>
