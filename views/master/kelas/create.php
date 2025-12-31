<?php
    // views/master/kelas/create.php
    ob_start();
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Data Kelas</h3>
                    </div>

                    <form action="<?php echo BASE_URL;?>/kelas/store" method="POST">
                        <div class="card-body">

                            <?php if (isset($_SESSION['flash']['error'])): ?>
                                <div class="alert alert-danger"><?php echo $_SESSION['flash']['error'];unset($_SESSION['flash']['error']);?></div>
                            <?php endif; ?>

                            <div class="form-group">
                                <label for="tingkat">Tingkat</label>
                                <select class="form-control" id="tingkat" name="tingkat" required>
                                    <option value="">-- Pilih Tingkat --</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="jurusan">Jurusan</label>
                                <input type="text" class="form-control" id="jurusan" name="jurusan" placeholder="Contoh: TKJ, RPL, AKL" required>
                            </div>

                            <div class="form-group">
                                <label for="nama_kelas">Nama Kelas</label>
                                <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" placeholder="Contoh: X TKJ 1" required>
                            </div>

                            <div class="form-group">
                                <label for="guru_wali_id">Wali Kelas</label>
                                <select class="form-control" id="guru_wali_id" name="guru_wali_id" required>
                                    <option value="">-- Pilih Wali Kelas --</option>
                                    <?php foreach ($data['gurus'] as $guru): ?>
                                        <option value="<?php echo $guru['guru_id'];?>">
                                            <?php echo htmlspecialchars($guru['nama_lengkap']);?> (NIP: <?php echo htmlspecialchars($guru['nip']);?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tahun_id">Tahun Ajaran</label>
                                <select class="form-control" id="tahun_id" name="tahun_id" required>
                                    <option value="">-- Pilih Tahun Ajaran --</option>
                                    <?php foreach ($data['tahuns'] as $tahun): ?>
                                        <option value="<?php echo $tahun['tahun_id'];?>">
                                            <?php echo htmlspecialchars($tahun['tahun'] . ' - ' . $tahun['semester']);?>
                                            <?php echo $tahun['is_active'] ? '(Aktif)' : '';?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?php echo BASE_URL;?>/kelas" class="btn btn-secondary">Batal</a>
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
