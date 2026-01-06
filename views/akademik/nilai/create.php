<?php ob_start(); ?>

<style type="text/css">
    :root {
        --color-bg-card: #ffffff;
        --color-primary: #2563eb;
        --color-border: #e5e7eb;
        --color-text-muted: #6b7280;
        --radius-lg: 12px;
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Layout Utama */
    .att-card { 
        background: var(--color-bg-card); 
        width: 100%; 
        border-radius: var(--radius-lg); 
        box-shadow: var(--shadow-md); 
        padding: 24px; 
        display: flex; 
        flex-direction: column; 
        gap: 24px; 
    }

    /* 1. Header Statistik */
    .att-header { display: flex; gap: 12px; overflow-x: auto; padding-bottom: 4px; }
    .att-stat { 
        flex: 1; display: flex; flex-direction: column; align-items: center; 
        padding: 12px 10px; border: 1px solid var(--color-border); 
        border-radius: 8px; min-width: 90px; text-align: center;
        background: #f8fafc;
    }
    .att-stat__count { display: block; font-weight: 700; font-size: 1.25rem; margin-bottom: 2px; color: var(--color-primary); } 
    .att-stat__label { font-size: 0.7rem; color: var(--color-text-muted); text-transform: uppercase; letter-spacing: 0.5px; }

    /* 2. Container List (Scrollable) */
    .att-list-container { 
        border: 1px solid var(--color-border); 
        border-radius: 12px; 
        overflow-x: auto; /* Scroll horizontal aktif */
        position: relative;
    }
    
    /* Baris (Row) */
    .att-row { 
        display: flex; 
        align-items: center; 
        padding: 12px 16px; 
        gap: 15px; 
        /* Total lebar minimal konten agar scroll muncul di HP */
        min-width: 700px; 
    }

    .att-list-header { 
        background-color: #f1f5f9; 
        border-bottom: 1px solid var(--color-border); 
        font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569; 
        
        /* Agar Header Nama juga Sticky */
        z-index: 30;
    }
    
    .att-item { border-bottom: 1px solid var(--color-border); }
    .att-item:last-child { border-bottom: none; }
    
    /* Efek Hover Baris */
    .att-item:hover { background-color: #f8fafc; }

    /* --- KOLOM STATUS --- */
    .col-no { width: 35px; text-align: center; flex-shrink: 0; color: #94a3b8; }
    .col-nis { width: 90px; flex-shrink: 0; color: #64748b; }

    /* --- PERBAIKAN STICKY NAME DISINI --- */
    .col-name { 
        width: 160px;     /* Lebar fix agar stabil */
        flex: none;       /* Jangan biarkan flex mengubah ukurannya */
        
        /* Styling Text */
        font-weight: 600; 
        color: #1e293b; 
        white-space: nowrap; 
        overflow: hidden; 
        text-overflow: ellipsis;
       
        /* Opsional: Border kanan untuk pemisah visual */
        border-right: 1px solid #e2e8f0; 
        padding-right: 10px;
        margin-right: 10px; /* Jarak sedikit ke input */
    }

    /* Agar background nama ikut berubah warna saat baris di-hover */
    .att-item:hover .col-name {
        background-color: #f8fafc; 
    }
    
    /* Header Nama juga harus sticky dan backgroundnya abu-abu header */
    .att-list-header .col-name {
        background-color: #f1f5f9;
        z-index: 30; /* Header harus paling atas */
    }

    /* Input Nilai Styles */
    .col-grade { width: 85px; text-align: center; flex-shrink: 0; }
    .col-final { width: 60px; text-align: center; flex-shrink: 0; font-weight: bold; color: var(--color-primary); }

    .grade-input {
        width: 100%;
        text-align: center;
        padding: 8px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .grade-input:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        outline: none;
    }
    
    /* Footer */
    .att-footer { margin-top: 10px; }
    .att-btn-primary { 
        width: 100%; padding: 14px; background-color: var(--color-primary); 
        color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; 
        transition: background 0.2s;
    }
    .att-btn-primary:hover { background-color: #1d4ed8; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 text-primary fw-bold">Input Nilai Siswa</h4>
        <p class="text-muted mb-0">
            <?php echo htmlspecialchars($kelas["nama_kelas"]); ?> | 
            <?php echo htmlspecialchars($mapel["nama_mapel"]); ?>
        </p>
    </div>
    <a href="<?php echo BASE_URL; ?>/nilai" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<form action="<?php echo BASE_URL; ?>/nilai/store" method="POST" id="formNilai">
    <input type="hidden" name="kelas_id" value="<?php echo $kelas[
        "kelas_id"
    ]; ?>">
    <input type="hidden" name="mapel_id" value="<?php echo $mapel[
        "mapel_id"
    ]; ?>">
    
    <div class="att-card">
        
        <header class="att-header">
            <div class="att-stat">
                <span class="att-stat__count" id="stat-avg">0</span>
                <span class="att-stat__label">Rata-rata</span>
            </div>
            <div class="att-stat">
                <span class="att-stat__count text-success" id="stat-max">0</span>
                <span class="att-stat__label">Tertinggi</span>
            </div>
            <div class="att-stat">
                <span class="att-stat__count text-danger" id="stat-min">0</span>
                <span class="att-stat__label">Terendah</span>
            </div>
            <div class="att-stat" style="border-color: #2563eb; background: #eff6ff;">
                <span class="att-stat__count" id="stat-pass">0</span>
                <span class="att-stat__label">Tuntas</span>
            </div>
        </header>

        <section class="att-list-container">
            <div class="att-row att-list-header">
                <span class="col-no">No</span>
                <span class="col-nis d-none d-md-block">NIS</span>
                <span class="col-name">Nama Siswa</span>
                <span class="col-grade text-muted small">Tugas<br>(30%)</span>
                <span class="col-grade text-muted small">UTS<br>(30%)</span>
                <span class="col-grade text-muted small">UAS<br>(40%)</span>
                <span class="col-final small">Akhir</span>
            </div>
            
            <div class="att-list">
                <?php foreach ($siswa as $idx => $s):

                    $tugas = $savedDetails[$s["siswa_id"]]["tugas"] ?? 0;
                    $uts = $savedDetails[$s["siswa_id"]]["uts"] ?? 0;
                    $uas = $savedDetails[$s["siswa_id"]]["uas"] ?? 0;
                    $akhir = $tugas * 0.3 + $uts * 0.3 + $uas * 0.4;

                    $readonly =
                        $existing &&
                        $existing["status_validasi"] === "Final"
                            ? "readonly disabled"
                            : "";
                    ?>
                <div class="att-item att-row" id="row-<?php echo $s[
                    "siswa_id"
                ]; ?>">
                    <span class="col-no"><?php echo $idx + 1; ?></span>
                    <span class="col-nis d-none d-md-block"><?php echo htmlspecialchars(
                        $s["nis"]
                    ); ?></span>
                    <span class="col-name">
                        <?php echo htmlspecialchars($s["nama_lengkap"]); ?>
                    </span>
                    
                    <div class="col-grade">
                        <input type="number" name="nilai[<?php echo $s[
                            "siswa_id"
                        ]; ?>][tugas]" 
                               class="grade-input inp-tugas" 
                               value="<?php echo $tugas; ?>" min="0" max="100" 
                               oninput="calcRow(this)" <?php echo $readonly; ?>>
                    </div>
                    <div class="col-grade">
                        <input type="number" name="nilai[<?php echo $s[
                            "siswa_id"
                        ]; ?>][uts]" 
                               class="grade-input inp-uts" 
                               value="<?php echo $uts; ?>" min="0" max="100" 
                               oninput="calcRow(this)" <?php echo $readonly; ?>>
                    </div>
                    <div class="col-grade">
                        <input type="number" name="nilai[<?php echo $s[
                            "siswa_id"
                        ]; ?>][uas]" 
                               class="grade-input inp-uas" 
                               value="<?php echo $uas; ?>" min="0" max="100" 
                               oninput="calcRow(this)" <?php echo $readonly; ?>>
                    </div>
                    <span class="col-final" id="final-<?php echo $s[
                        "siswa_id"
                    ]; ?>">
                        <?php echo number_format($akhir, 2, ",", "."); ?>
                    </span>
                </div>
                <?php
                endforeach; ?>
            </div>
        </section>

        <?php if (
            !$existing ||
            $existing["status_validasi"] !== "Final"
        ): ?>
        <div class="att-footer">
            <button type="submit" class="att-btn-primary">
                <i class="bi bi-save me-2"></i> Simpan Nilai
            </button>
        </div>
        <?php endif; ?>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    calculateStats();
});

function calcRow(input) {
    let val = parseFloat(input.value);
    if (isNaN(val)) val = 0; // Fix NaN issue saat input kosong
    if (val > 100) val = 100;
    if (val < 0) val = 0;
    
    // Update value di input (opsional, agar user tidak input aneh2)
    // input.value = val; 

    const row = input.closest('.att-row');
    const tugas = parseFloat(row.querySelector('.inp-tugas').value) || 0;
    const uts   = parseFloat(row.querySelector('.inp-uts').value) || 0;
    const uas   = parseFloat(row.querySelector('.inp-uas').value) || 0;

    const akhir = (tugas * 0.30) + (uts * 0.30) + (uas * 0.40);
    
    // Format angka desimal koma
    row.querySelector('.col-final').textContent = akhir.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});

    calculateStats();
}

function calculateStats() {
    let total = 0;
    let count = 0;
    let max = -1;
    let min = 101;
    let passCount = 0;
    const KKM = 75;

    document.querySelectorAll('.col-final').forEach(el => {
        // Replace koma ke titik untuk parsing float
        const valText = el.textContent.replace(',', '.');
        const val = parseFloat(valText) || 0;
        
        total += val;
        count++;

        if (val > max) max = val;
        if (val < min) min = val;
        if (val >= KKM) passCount++;
    });
    
    count--;

    if (count > 0) {
        document.getElementById('stat-avg').textContent = (total / count).toLocaleString('id-ID', {maximumFractionDigits: 1});
        document.getElementById('stat-max').textContent = max.toLocaleString('id-ID', {maximumFractionDigits: 1});
        document.getElementById('stat-min').textContent = min.toLocaleString('id-ID', {maximumFractionDigits: 1});
        document.getElementById('stat-pass').textContent = passCount + "/" + count;
    } else {
        // Fix NaN jika data kosong
        document.getElementById('stat-avg').textContent = "0";
        document.getElementById('stat-max').textContent = "0";
        document.getElementById('stat-min').textContent = "0";
        document.getElementById('stat-pass').textContent = "0";
    }
}
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . "/../../layouts/main.php";

?>
