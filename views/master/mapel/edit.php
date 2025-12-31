<?php
    // views/master/mapel/edit.php
    ob_start();
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Edit Mata Pelajaran</h3>
                    </div>

                    <form action="<?php echo BASE_URL; ?>/mapel/update" method="POST">
                        <input type="hidden" name="mapel_id" value="<?php echo $data['mapel']['mapel_id']; ?>">

                        <div class="card-body">

                            <div class="form-group">
                                <label for="kode_mapel">Kode Mapel</label>
                                <input type="text" class="form-control" id="kode_mapel" name="kode_mapel"
                                       value="<?php echo htmlspecialchars($data['mapel']['kode_mapel']); ?>"
                                       placeholder="Contoh: MTK, WEB-1"
                                       style="text-transform: uppercase;" required>
                            </div>

                            <div class="form-group">
                                <label for="nama_mapel">Nama Mapel</label>
                                <input type="text" class="form-control" id="nama_mapel" name="nama_mapel"
                                       value="<?php echo htmlspecialchars($data['mapel']['nama_mapel']); ?>"
                                       placeholder="Contoh: Matematika Wajib" required>
                            </div>

                            <div class="form-group">
                                <label for="kelompok">Kelompok</label>
                                <select class="form-control" id="kelompok" name="kelompok" required>
                                    <option value="">-- Pilih Kelompok --</option>
                                    <option value="A"                                                      <?php echo $data['mapel']['kelompok'] == 'A' ? 'selected' : ''; ?>>A - Muatan Nasional</option>
                                    <option value="B"                                                      <?php echo $data['mapel']['kelompok'] == 'B' ? 'selected' : ''; ?>>B - Muatan Kewilayahan</option>
                                    <option value="C1"                                                       <?php echo $data['mapel']['kelompok'] == 'C1' ? 'selected' : ''; ?>>C1 - Dasar Bidang Keahlian</option>
                                    <option value="C2"                                                       <?php echo $data['mapel']['kelompok'] == 'C2' ? 'selected' : ''; ?>>C2 - Dasar Program Keahlian</option>
                                    <option value="C3"                                                       <?php echo $data['mapel']['kelompok'] == 'C3' ? 'selected' : ''; ?>>C3 - Kompetensi Keahlian</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="kkm">KKM</label>
                                <input type="number" class="form-control" id="kkm" name="kkm"
                                       value="<?php echo htmlspecialchars($data['mapel']['kkm']); ?>"
                                       min="0" max="100" required>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-warning">Update</button>
                            <a href="<?php echo BASE_URL; ?>/mapel" class="btn btn-secondary">Batal</a>
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
