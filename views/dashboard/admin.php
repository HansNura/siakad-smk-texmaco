<div class="row">
    <div class="col-12">
        <div class="dashboard-header">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2>Halo, <?php echo htmlspecialchars(
                        $username ?? "Admin"
                    ); ?>! 👋</h2>
                    <p class="mb-0">Selamat datang kembali di Panel Administrasi Sekolah.</p>
                    <small class="text-white-50">Role: <?php echo $role; ?> | <?php echo date(
     "d F Y"
 ); ?></small>
                </div>
                <div class="d-none d-md-block" style="font-size: 3rem; opacity: 0.8;">
                    <i class="bi bi-shield-check"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-md-6 col-xl-3">
        <a href="<?php echo BASE_URL; ?>/siswa" class="stat-card">
            <div class="stat-icon theme-blue">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo number_format($total_siswa ?? 0); ?></h3>
                <p>Siswa Aktif</p>
            </div>
        </a>
    </div>

    <div class="col-12 col-md-6 col-xl-3">
        <a href="<?php echo BASE_URL; ?>/guru" class="stat-card">
            <div class="stat-icon theme-green">
                <i class="bi bi-person-badge-fill"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo number_format($total_guru ?? 0); ?></h3>
                <p>Guru Pengajar</p>
            </div>
        </a>
    </div>

    <div class="col-12 col-md-6 col-xl-3">
        <a href="<?php echo BASE_URL; ?>/kelas" class="stat-card">
            <div class="stat-icon theme-orange">
                <i class="bi bi-building-fill"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo number_format($total_kelas ?? 0); ?></h3>
                <p>Total Kelas</p>
            </div>
        </a>
    </div>

    <div class="col-12 col-md-6 col-xl-3">
        <a href="<?php echo BASE_URL; ?>/mapel" class="stat-card">
            <div class="stat-icon theme-red">
                <i class="bi bi-journal-bookmark-fill"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo number_format($total_mapel ?? 0); ?></h3>
                <p>Mata Pelajaran</p>
            </div>
        </a>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12 mb-3">
        <h5 class="text-muted fw-bold">Akses Cepat</h5>
    </div>
    
    <div class="col-6 col-md-3 col-lg-2">
        <a href="<?php echo BASE_URL; ?>/siswa/create" class="btn-quick">
            <i class="bi bi-person-plus"></i>
            <span>Tambah Siswa</span>
        </a>
    </div>
    
    <div class="col-6 col-md-3 col-lg-2">
        <a href="<?php echo BASE_URL; ?>/guru/create" class="btn-quick">
            <i class="bi bi-person-plus-fill"></i>
            <span>Tambah Guru</span>
        </a>
    </div>
    
    <div class="col-6 col-md-3 col-lg-2">
        <a href="<?php echo BASE_URL; ?>/jadwal" class="btn-quick">
            <i class="bi bi-calendar-week"></i>
            <span>Jadwal Pelajaran</span>
        </a>
    </div>

    <div class="col-6 col-md-3 col-lg-2">
        <a href="<?php echo BASE_URL; ?>/pengumuman" class="btn-quick">
            <i class="bi bi-megaphone"></i>
            <span>Buat Pengumuman</span>
        </a>
    </div>
</div>
