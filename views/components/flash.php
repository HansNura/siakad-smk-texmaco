<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["flash"])):

    $flash = $_SESSION["flash"];
    $type = $flash["type"] ?? "info";
    $title = $flash["title"] ?? ucfirst($type);
    $message = $flash["message"] ?? "";

    // Mapping Icon Modern (Bootstrap Icons path)
    $icons = [
        "success" =>
            '<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>',
        "info" =>
            '<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>',
        "warning" =>
            '<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>',
        "error" =>
            '<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>',
        "question" =>
            '<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.009.927z"/>',
    ];
    $iconPath = $icons[$type] ?? $icons["info"];
    ?>

<style>
    /* Container Fixed */
    .flash-container {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 99999;
        display: flex;
        flex-direction: column;
        gap: 15px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        pointer-events: none; /* Agar klik tembus ke belakang jika area kosong */
    }

    /* Kartu Flash */
    .flash-card {
        pointer-events: auto; /* Aktifkan klik pada kartu */
        background: white;
        min-width: 320px;
        max-width: 400px;
        border-radius: 12px;
        box-shadow: 0 10px 30px -5px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
        display: flex;
        overflow: hidden;
        position: relative;
        animation: slideInRight 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        transform: translateX(120%);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .flash-card.closing {
        animation: fadeOutRight 0.4s forwards;
    }

    @keyframes slideInRight {
        to { transform: translateX(0); }
    }
    @keyframes fadeOutRight {
        to { transform: translateX(120%); opacity: 0; }
    }

    /* Strip Warna Kiri */
    .flash-strip { width: 6px; flex-shrink: 0; }
    
    /* Content Area */
    .flash-body {
        padding: 16px 16px 16px 12px;
        flex: 1;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    /* Icon Box */
    .flash-icon {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        margin-top: 2px;
    }

    /* Texts */
    .flash-text { flex: 1; }
    .flash-title {
        display: block;
        font-weight: 700;
        font-size: 0.95rem;
        color: #1e293b;
        margin-bottom: 2px;
    }
    .flash-message {
        display: block;
        font-size: 0.875rem;
        color: #64748b;
        line-height: 1.5;
    }

    /* Close Button */
    .flash-close {
        background: transparent;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 4px;
        font-size: 1.2rem;
        line-height: 1;
        margin-left: 8px;
        transition: color 0.2s;
    }
    .flash-close:hover { color: #334155; }

    /* Progress Bar (Auto Dismiss) */
    .flash-progress {
        position: absolute;
        bottom: 0; left: 0;
        height: 3px;
        background: rgba(0,0,0,0.1);
        width: 100%;
        transform-origin: left;
    }
    /* Hanya animasi progress jika BUKAN tipe question */
    .flash-card:not(.type-question) .flash-progress {
        animation: progressLinear 4s linear forwards;
    }

    @keyframes progressLinear {
        from { transform: scaleX(1); }
        to { transform: scaleX(0); }
    }

    /* COLOR THEMES */
    .type-success .flash-strip { background: #10b981; }
    .type-success .flash-icon { fill: #10b981; }
    
    .type-info .flash-strip { background: #3b82f6; }
    .type-info .flash-icon { fill: #3b82f6; }
    
    .type-warning .flash-strip { background: #f59e0b; }
    .type-warning .flash-icon { fill: #f59e0b; }
    
    .type-error .flash-strip { background: #ef4444; }
    .type-error .flash-icon { fill: #ef4444; }

    .type-question .flash-strip { background: #8b5cf6; }
    .type-question .flash-icon { fill: #8b5cf6; }

    /* Question Buttons */
    .flash-actions {
        margin-top: 12px;
        display: flex;
        gap: 8px;
    }
    .btn-action {
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: transform 0.1s;
    }
    .btn-action:active { transform: scale(0.96); }
    
    .btn-yes { background: #8b5cf6; color: white; }
    .btn-yes:hover { background: #7c3aed; }
    
    .btn-no { background: #f1f5f9; color: #475569; }
    .btn-no:hover { background: #e2e8f0; }
</style>

<div class="flash-container">
    <div class="flash-card type-<?php echo $type; ?>" id="flashCard">
        
        <div class="flash-strip"></div>
        
        <div class="flash-body">
            <svg class="flash-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                <?php echo $iconPath; ?>
            </svg>
            
            <div class="flash-text">
                <span class="flash-title"><?php echo htmlspecialchars(
                    $title
                ); ?></span>
                <span class="flash-message"><?php echo htmlspecialchars(
                    $message
                ); ?></span>

                <?php if ($type === "question"): ?>
                    <div class="flash-actions">
                        <button class="btn-action btn-yes" onclick="confirmAction()">Ya, Lanjutkan</button>
                        <button class="btn-action btn-no" onclick="dismissFlash()">Batal</button>
                    </div>
                <?php endif; ?>
            </div>

            <button class="flash-close" onclick="dismissFlash()">&times;</button>
        </div>

        <?php if ($type !== "question"): ?>
            <div class="flash-progress"></div>
        <?php endif; ?>
    </div>
</div>

<script>
    const flashCard = document.getElementById('flashCard');

    function dismissFlash() {
        if(!flashCard) return;
        flashCard.classList.add('closing');
        setTimeout(() => {
            flashCard.remove();
        }, 400); // Sesuai durasi animasi CSS
    }

    function confirmAction() {
        // Logika konfirmasi kustom bisa ditambahkan di sini
        // Misal submit form tertentu atau redirect
        // Untuk sekarang kita hanya tutup saja
        alert('Aksi dikonfirmasi!');
        dismissFlash();
    }

    // Auto Dismiss (Kecuali Question)
    <?php if ($type !== "question"): ?>
    setTimeout(() => {
        dismissFlash();
    }, 4000); // 4 Detik
    <?php endif; ?>
</script>

<?php // Hapus sesi flash setelah ditampilkan
unset($_SESSION["flash"]);
endif;
?>
