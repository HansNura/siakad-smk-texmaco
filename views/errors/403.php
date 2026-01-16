<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Dibatasi</title>
    <style>
        :root {
            /* Palette sesuai Pedoman Desain */
            --c-primary: #0f172a;
            --c-accent: #2563eb;
            --c-danger: #ef4444;
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
            max-width: 480px;
            width: 100%;
            padding: 40px;
            border-radius: var(--radius);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            text-align: center;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .icon-container {
            width: 80px;
            height: 80px;
            background-color: #fef2f2; /* Merah soft */
            color: var(--c-danger);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .icon-lock {
            width: 40px;
            height: 40px;
        }

        h1 {
            font-size: 3rem;
            font-weight: 800;
            color: var(--c-primary);
            margin: 0;
            line-height: 1;
            letter-spacing: -1px;
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
            border-radius: 8px;
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
            margin-top: 30px;
            font-size: 0.8rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    
    <div class="error-card">
        <div class="icon-container">
            <svg class="icon-lock" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
        </div>

        <h1>403</h1>
        <h2>Akses Dibatasi</h2>
        
        <p>
            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. <br>
            Pastikan Anda login dengan akun yang memiliki hak akses yang sesuai.
        </p>

        <a href="/" class="btn">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Dashboard
        </a>

        <div class="footer-text">
            SIAKAD Texmaco &copy; <?php echo date('Y'); ?>
        </div>
    </div>

</body>
</html>
