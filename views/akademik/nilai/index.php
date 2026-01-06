<?php
/**
 * View: List Kelas & Mapel untuk Input Nilai
 */
?>
<?php ob_start(); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 offset-md-1"> <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit me-2"></i> <?php echo $title; ?>
                    </h3>
                </div>
                
                <div class="card-body">
                    <?php showAlert(); ?>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-1"></i>
                        Silakan pilih kelas untuk mulai menginput atau mengedit nilai siswa.
                    </div>
                        
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 20%">Kelas</th>
                                    <th style="width: 35%">Mata Pelajaran</th>
                                    <th style="width: 20%">Status Input</th>
                                    <th style="width: 20%" class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($listMengajar)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            Anda tidak memiliki jadwal mengajar aktif saat ini.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = 1; foreach ($listMengajar as $item): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary fs-6">
                                                <?php echo htmlspecialchars($item["nama_kelas"]); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark"><?php echo htmlspecialchars($item["nama_mapel"]); ?></div>
                                            <small class="text-muted">Kode: <?php echo htmlspecialchars($item["kode_mapel"] ?? '-'); ?></small>
                                        </td>
                                        <td>
                                            <?php
                                            $status = $item["status_nilai"]; // Belum Input, Draft, Final
                                            $badgeClass = "bg-secondary";
                                            $icon = "fa-circle";

                                            if ($status === "Belum Input") {
                                                $badgeClass = "bg-secondary";
                                                $icon = "fa-circle-notch";
                                            } elseif ($status === "Draft") {
                                                $badgeClass = "bg-warning text-dark"; // Draft = Kuning
                                                $icon = "fa-pen";
                                            } elseif ($status === "Final") {
                                                $badgeClass = "bg-success"; // Final = Hijau
                                                $icon = "fa-check-circle";
                                            }
                                            ?>
                                            <span class="badge <?php echo $badgeClass; ?> p-2">
                                                <i class="fas <?php echo $icon; ?> me-1"></i> <?php echo $status; ?>
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <?php if($status === 'Final'): ?>
                                                <a href="<?php echo BASE_URL; ?>/nilai/create?kelas_id=<?php echo $item["kelas_id"]; ?>&mapel_id=<?php echo $item["mapel_id"]; ?>" 
                                                   class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-eye"></i> Lihat Nilai
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo BASE_URL; ?>/nilai/create?kelas_id=<?php echo $item["kelas_id"]; ?>&mapel_id=<?php echo $item["mapel_id"]; ?>" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> <?php echo ($status === 'Belum Input') ? 'Mulai Input' : 'Edit Nilai'; ?>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-white">
                    <a href="<?php echo BASE_URL; ?>/dashboard" class="btn btn-secondary text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . "/../../layouts/main.php";
?>