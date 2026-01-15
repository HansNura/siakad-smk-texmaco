<?php ob_start(); ?>

<style>
    /* Dashboard Specific Style */
.dashboard-header {
    background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%);
    color: white;
    border-radius: 15px;
    padding: 30px;
    position: relative;
    overflow: hidden;
    margin-bottom: 30px;
    box-shadow: 0 10px 20px rgba(78, 84, 200, 0.2);
}

.dashboard-header h2 { font-weight: 700; margin-bottom: 10px; }
.dashboard-header p { opacity: 0.9; font-size: 1.1rem; }

/* Decoration Circle in Header */
.dashboard-header::after {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
}

/* Stat Cards */
.stat-card {
    background: #fff;
    border: none;
    border-radius: 15px;
    padding: 25px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    height: 100%;
    display: flex;
    align-items: center;
    text-decoration: none; /* remove underline from link */
    color: inherit;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    color: inherit;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin-right: 20px;
    flex-shrink: 0;
}

.stat-content h3 {
    font-size: 28px;
    font-weight: 700;
    margin: 0;
    color: #2c3e50;
    line-height: 1;
}

.stat-content p {
    margin: 5px 0 0;
    color: #95a5a6;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Icon Color Themes (Soft Background + Solid Icon) */
.theme-blue { background: #e3f2fd; color: #1976d2; }
.theme-green { background: #e8f5e9; color: #2e7d32; }
.theme-orange { background: #fff3e0; color: #f57c00; }
.theme-red { background: #ffebee; color: #c62828; }

/* Quick Action Buttons (Optional) */
.btn-quick {
    background: white;
    border: 1px solid #eee;
    padding: 15px;
    border-radius: 12px;
    text-align: center;
    transition: all 0.2s;
    color: #555;
    text-decoration: none;
    display: block;
    box-shadow: 0 2px 5px rgba(0,0,0,0.02);
}
.btn-quick:hover {
    background: #f8f9fa;
    border-color: #ddd;
    color: #333;
}
.btn-quick i {
    display: block;
    font-size: 24px;
    margin-bottom: 8px;
    color: #4e54c8;
}

</style>

<?php if (isset($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi Kesalahan!</strong> <?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php
// Render konten berdasarkan role
switch ($role) {
    case 'Admin':
    case 'Kepsek':
        include 'dashboard/admin.php';
        break;
    case 'Guru':
        include 'dashboard/guru.php';
        break;
    case 'Siswa':
        include 'dashboard/siswa.php';
        break;
    default:
        echo '<div class="alert alert-warning">Role tidak dikenal</div>';
}
?>

<?php
    $content = ob_get_clean();
    // Pastikan path ke layout main benar
    require_once __DIR__ . '/layouts/main.php';
?>
