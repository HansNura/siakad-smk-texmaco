<?php ob_start(); ?>

<section class="content">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Siswa</h3>
        </div>

        <form action="<?php echo BASE_URL ?>/siswa/store" method="post">
            <div class="card-body">

                <div class="form-group">
                    <label>NIS</label>
                    <input type="text" name="nis" class="form-control" placeholder="Masukkan nis unik">
                </div>
                <div class="form-group">
                    <label>NISN</label>
                    <input type="text" name="nisn" class="form-control" placeholder="Masukkan nisn unik">
                </div>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan Nama Lengkap">
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control">
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" rows="3" placeholder="Enter ..." name="alamat"></textarea>
                </div>

                <div class="form-group">
                    <label>Kelas</label>
                    <select name="kelas_id" class="form-control">
                        <option value="" disabled selected>Pilih Kelas</option>
                        <?php foreach ($kelas as $k): ?>
                        <option value="<?php echo $k['kelas_id'] ?>"><?php echo $k['nama_kelas'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>
            <div class="card-footer">
                <a href="<?php echo BASE_URL ?>/siswa" class="btn btn-default">Batal</a>
                <button type="submit" class="btn btn-primary float-right">Simpan Siswa</button>
            </div>
        </form>
    </div>
</section>

<?php
    $content = ob_get_clean();
require_once __DIR__ . '/../../layouts/main.php';
?>