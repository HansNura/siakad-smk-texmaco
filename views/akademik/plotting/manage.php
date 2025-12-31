<?php
    ob_start();
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 text-primary fw-bold">Kelola Rombel: <?php echo htmlspecialchars($kelas['nama_kelas']) ?></h4>
        <p class="text-muted mb-0">Kode: <?php echo htmlspecialchars($kelas['nama_kelas']) ?> | Jurusan:
            <?php echo htmlspecialchars($kelas['jurusan']) ?></p>
    </div>
    <a href="<?php echo BASE_URL ?>/plotting" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row">
    <!-- Kolom Kiri: Siswa Belum Dapat Kelas -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100 border-0">
            <div class="card-header bg-warning bg-opacity-10 py-3">
                <h6 class="mb-0 fw-bold text-warning-emphasis"><i class="bi bi-person-plus-fill me-2"></i>Siswa Belum
                    Dapat Kelas</h6>
            </div>
            <div class="card-body">
                <?php if (empty($unassigned)): ?>
                <div class="alert alert-success text-center mb-0">
                    <i class="bi bi-check-circle me-1"></i> Semua siswa sudah mendapat kelas.
                </div>
                <?php else: ?>
                <form action="<?php echo BASE_URL ?>/plotting/add" method="POST">
                    <input type="hidden" name="kelas_id" value="<?php echo $kelas['kelas_id'] ?>">

                    <div class="table-responsive mb-3" style="max-height: 500px; overflow-y: auto;">
                        <table class="table table-sm table-hover table-bordered">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th width="40" class="text-center">
                                        <input type="checkbox" id="checkAll" class="form-check-input">
                                    </th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($unassigned as $s): ?>
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="siswa_id[]" value="<?php echo $s['siswa_id'] ?>"
                                            class="form-check-input siswa-checkbox">
                                    </td>
                                    <td><?php echo htmlspecialchars($s['nis']) ?></td>
                                    <td><?php echo htmlspecialchars($s['nama_lengkap']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" id="btnAdd" disabled>
                            <i class="bi bi-arrow-right-circle me-1"></i> Masukkan ke Kelas Ini
                        </button>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Siswa Terdaftar -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100 border-0">
            <div class="card-header bg-success bg-opacity-10 py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-success-emphasis"><i class="bi bi-people-fill me-2"></i>Anggota Kelas
                    (<?php echo count($assigned) ?>)</h6>
            </div>
            <div class="card-body">
                <?php if (empty($assigned)): ?>
                <div class="alert alert-secondary text-center mb-0">
                    <i class="bi bi-info-circle me-1"></i> Belum ada siswa di kelas ini.
                </div>
                <?php else: ?>
                <div class="table-responsive" style="max-height: 550px; overflow-y: auto;">
                    <table class="table table-sm table-hover align-middle">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th class="text-center" width="50">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($assigned as $idx => $s): ?>
                            <tr>
                                <td><?php echo $idx + 1 ?></td>
                                <td><?php echo htmlspecialchars($s['nis']) ?></td>
                                <td><?php echo htmlspecialchars($s['nama_lengkap']) ?></td>
                                <td class="text-center">
                                    <form action="<?php echo BASE_URL ?>/plotting/remove" method="POST"
                                        onsubmit="return confirm('Keluarkan siswa ini dari kelas?');">
                                        <input type="hidden" name="kelas_id" value="<?php echo $kelas['kelas_id'] ?>">
                                        <input type="hidden" name="siswa_id" value="<?php echo $s['siswa_id'] ?>">
                                        <button type="submit" class="btn btn-xs btn-outline-danger" title="Keluarkan">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
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

<script>
// Script for Check All
document.getElementById('checkAll')?.addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.siswa-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
    updateButtonState();
});

// Enable/Disable Add Button
const checkBoxes = document.querySelectorAll('.siswa-checkbox');
checkBoxes.forEach(cb => {
    cb.addEventListener('change', updateButtonState);
});

function updateButtonState() {
    const checkedCount = document.querySelectorAll('.siswa-checkbox:checked').length;
    const btn = document.getElementById('btnAdd');
    if (btn) {
        btn.disabled = checkedCount === 0;
        btn.innerHTML = checkedCount > 0 ?
            `<i class="bi bi-arrow-right-circle me-1"></i> Masukkan ${checkedCount} Siswa` :
            `<i class="bi bi-arrow-right-circle me-1"></i> Masukkan ke Kelas Ini`;
    }
}
</script>


<?php
    $content = ob_get_clean();
require_once __DIR__ . '/../../layouts/main.php';
?>