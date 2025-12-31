<?php
    // views/master/tahun_ajaran/edit.php
    ob_start();
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Edit Tahun Ajaran</h3>
                    </div>

                    <form action="<?php echo BASE_URL; ?>/tahun-ajaran/update" method="POST">
                        <input type="hidden" name="tahun_id" value="<?php echo $data['tahun_ajaran']['tahun_id']; ?>">

                        <div class="card-body">

                            <?php if (isset($_SESSION['flash']['error'])): ?>
                            <div class="alert alert-danger">
                                <?php echo $_SESSION['flash']['error'];unset($_SESSION['flash']['error']); ?></div>
                            <?php endif; ?>

                            <div class="form-group">
                                <label for="tahun">Tahun Ajaran</label>
                                <input type="text" class="form-control" id="tahun" name="tahun"
                                    value="<?php echo htmlspecialchars($data['tahun_ajaran']['tahun']); ?>"
                                    placeholder="Contoh: 2024/2025" required>
                            </div>

                            <div class="form-group">
                                <label for="semester">Semester</label>
                                <select class="form-control" id="semester" name="semester" required>
                                    <option value="Ganjil"
                                        <?php echo $data['tahun_ajaran']['semester'] == 'Ganjil' ? 'selected' : ''; ?>>
                                        Ganjil</option>
                                    <option value="Genap"
                                        <?php echo $data['tahun_ajaran']['semester'] == 'Genap' ? 'selected' : ''; ?>>
                                        Genap</option>
                                </select>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-warning">Update</button>
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