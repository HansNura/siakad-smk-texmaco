<?php ob_start(); ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-primary">Input Catatan Rapor</h4>
            <a href="<?php echo BASE_URL; ?>/rapor" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    Siswa: <strong><?php echo htmlspecialchars($biodata['nama_lengkap']); ?></strong> 
                    (<?php echo htmlspecialchars($biodata['nis']); ?>)
                </h6>
            </div>
            
            <div class="card-body">
                <?php showAlert(); ?>

                <form action="<?php echo BASE_URL; ?>/rapor/catatan/store" method="POST">
                    <input type="hidden" name="siswa_id" value="<?php echo $biodata['siswa_id']; ?>">

                    <div class="mb-4">
                        <label for="sikap" class="form-label fw-bold">1. Catatan Sikap / Karakter</label>
                        <textarea name="catatan_sikap" id="sikap" class="form-control" rows="4" 
                            placeholder="Contoh: Ananda sangat disiplin, sopan kepada guru, dan aktif dalam kegiatan sosial..." required><?php echo htmlspecialchars($catatan['catatan_sikap'] ?? ''); ?></textarea>
                        <div class="form-text">Deskripsikan perkembangan perilaku dan kedisiplinan siswa.</div>
                    </div>

                    <div class="mb-4">
                        <label for="akademik" class="form-label fw-bold">2. Catatan Akademik</label>
                        <textarea name="catatan_akademik" id="akademik" class="form-control" rows="4" 
                            placeholder="Contoh: Prestasi akademik meningkat pesat, namun perlu lebih teliti dalam mata pelajaran Eksakta..." required><?php echo htmlspecialchars($catatan['catatan_akademik'] ?? ''); ?></textarea>
                        <div class="form-text">Berikan saran atau pujian terkait capaian pembelajaran.</div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Simpan Catatan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . "/../../layouts/main.php";
?>
