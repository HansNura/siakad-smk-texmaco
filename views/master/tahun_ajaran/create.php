<?php
    // views/master/tahun_ajaran/create.php
    ob_start();
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Tahun Ajaran</h3>
                    </div>

                    <form action="<?php echo BASE_URL; ?>/tahun-ajaran/store" method="POST">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="tahun">Tahun Ajaran</label>
                                <input type="text" class="form-control" id="tahun" name="tahun" placeholder="Contoh: 2024/2025" required>
                            </div>

                            <div class="form-group">
                                <label for="semester">Semester</label>
                                <select class="form-control" id="semester" name="semester" required>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> Status awal akan diset "Non-Aktif". Anda dapat mengaktifkannya melalui halaman Index.
                                </small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?php echo BASE_URL; ?>/tahun-ajaran" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    require_once __DIR__ . '/../../layouts/main.php';
?>
