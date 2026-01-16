<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <style>
        :root {
            /* Palette Blue Professional */
            --c-primary: #0f172a;
            --c-accent: #2563eb;
            --c-bg-page: #f1f5f9;
            --c-text-main: #1e293b;
            --c-text-muted: #64748b;
            --radius: 16px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: var(--c-bg-page);
            color: var(--c-text-main);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .error-card {
            background: white;
            max-width: 500px;
            width: 100%;
            padding: 50px 30px;
            border-radius: var(--radius);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            text-align: center;
            border: 1px solid rgba(0,0,0,0.05);
        }

        /* Icon Container (Konsisten dengan 403) */
        .icon-container {
            width: 90px;
            height: 90px;
            background-color: #eff6ff; /* Biru sangat muda */
            color: var(--c-accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            position: relative;
        }

        /* Sedikit animasi float biar tidak kaku, tapi tetap tenang */
        .icon-svg {
            width: 45px;
            height: 45px;
            animation: float 4s ease-in-out infinite;
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--c-primary);
            margin: 0;
            line-height: 1;
            letter-spacing: -2px;
        }

        h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-top: 10px;
            margin-bottom: 12px;
            color: var(--c-text-main);
        }

        p {
            color: var(--c-text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 30px;
            padding: 0 20px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background-color: var(--c-accent);
            color: white;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 8px; /* Radius kotak rounded, bukan bulat penuh */
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        }

        .btn:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 6px 10px -1px rgba(37, 99, 235, 0.3);
        }

        .footer-text {
            margin-top: 40px;
            font-size: 0.8rem;
            color: #94a3b8;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body>

    <div class="error-card">
        <div class="icon-container">
            <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="9" y1="15" x2="15" y2="15"></line>
                <circle cx="10" cy="15" r="3" transform="translate(2 2)"></circle> 
                <path d="M14 17l2 2"></path>
            </svg>
        </div>

        <h1>404</h1>
        <h2>Halaman Tidak Ditemukan</h2>
        <p>
            Ups! Halaman yang Anda cari sepertinya tidak ada di sistem kami. 
            Mungkin tautan rusak atau halaman telah dipindahkan.
        </p>
        
        <a href="/" class="btn">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Kembali ke Beranda
        </a>

        <div class="footer-text">
            SIAKAD Texmaco &copy; <?php echo date('Y'); ?>
        </div>
    </div>
</body>
</html>
