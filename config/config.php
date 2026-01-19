<?php

// =========================================================================
// 1. HELPER: LOAD .ENV (Untuk Localhost Tanpa Library Tambahan)
// =========================================================================
function loadEnv($path) {
    if (!file_exists($path)) {
        return; // Jika file .env tidak ada (misal di Wasmer), abaikan.
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Skip komentar

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Panggil fungsi loadEnv (arahkan ke file .env di root folder)
loadEnv(__DIR__ . '/../.env');


// =========================================================================
// 2. KONFIGURASI DATABASE
// =========================================================================
// Logikanya: Coba ambil dari Environment Variable (Wasmer/.env), 
// jika tidak ada, baru pakai default (untuk jaga-jaga).

// =========================================================================
// 2. KONFIGURASI DATABASE
// =========================================================================

// Host & Port (Wasmer pakai DB_HOST dan DB_PORT)
define("DB_HOST", getenv("DB_HOST") ?: "127.0.0.1");
define("DB_PORT", getenv("DB_PORT") ?: "3306"); 
define("DB_NAME", getenv("DB_NAME") ?: "db_siakad_texmaco");
define("DB_USERNAME", getenv("DB_USERNAME") ?: "root");
define("DB_PASSWORD", getenv("DB_PASSWORD") ?: "");


// =========================================================================
// 3. KONFIGURASI APP & BASE URL DINAMIS
// =========================================================================
define("APP_NAME", "Siakad SMK Texmaco Subang");
define("APP_DESCRIPTION", "Sistem Informasi Akademik SMK Texmaco Subang");

// Deteksi URL otomatis (Localhost atau Wasmer/Hosting)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";
$domain = $_SERVER['HTTP_HOST'] ?? 'localhost';
define("BASE_URL", $protocol . "://" . $domain);

define("BASE_PATH", __DIR__ . "/..");

// =========================================================================
// 4. ENUMERASI DATA
// =========================================================================
define("ENUM", [
    "STATUS" => [
        "Belum Input" => "Belum Input",
        "Valid" => "Valid",
        "Pending" => "Pending",
        "Rejected" => "Rejected",
    ],
    "STATUS_KEHADIRAN" => [
        "Hadir" => "Hadir",
        "Izin" => "Izin",
        "Sakit" => "Sakit",
        "Alpa" => "Alpa",
    ],
    "HARI" => [
        "Sunday" => "Minggu",
        "Monday" => "Senin",
        "Tuesday" => "Selasa",
        "Wednesday" => "Rabu",
        "Thursday" => "Kamis",
        "Friday" => "Jumat",
        "Saturday" => "Sabtu",
    ],
]);

// =========================================================================
// 5. DATA HARDCODED (Akun Dummy)
// =========================================================================
define("ADMIN_USERNAME", "admin");
define("ADMIN_PASSWORD", "admin");

define("SISWA_USERNAME", "siswa");
define("SISWA_PASSWORD", "siswa");

define("GURU_USERNAME", "guru");
define("GURU_PASSWORD", "guru");

// =========================================================================
// 6. HELPER FUNCTION (DEBUGGING)
// =========================================================================
function dd($data)
{
    $backtrace = debug_backtrace();
    $caller = array_shift($backtrace);
    $file = $caller['file'] ?? 'unknown';
    $line = $caller['line'] ?? 'unknown';

    echo "<style>
        .dd-wrapper { background-color: #1e1e1e; color: #d4d4d4; font-family: monospace; padding: 15px; z-index:99999; position:relative; }
        .dd-header { border-bottom: 1px solid #333; margin-bottom: 10px; color: #888; font-size: 12px; }
        details { margin-left: 15px; }
        summary { cursor: pointer; outline: none; }
        .dd-key { color: #9cdcfe; }
        .dd-str { color: #ce9178; }
        .dd-num { color: #b5cea8; }
    </style>";

    // Simple recursive renderer
    $render = function ($item, $key = null) use (&$render) {
        $keyHtml = $key !== null ? "<span class='dd-key'>\"{$key}\"</span> => " : "";
        if (is_array($item) || is_object($item)) {
            $count = count((array)$item);
            $type = is_object($item) ? get_class($item) : "Array";
            echo "<details open><summary>{$keyHtml}<span style='color:#4ec9b0'>{$type}</span> [{$count}]</summary>";
            foreach ($item as $k => $v) $render($v, $k);
            echo "</details>";
        } else {
            $val = is_string($item) ? "<span class='dd-str'>\"".htmlspecialchars($item)."\"</span>" : "<span class='dd-num'>$item</span>";
            echo "<div style='margin-left:15px'>{$keyHtml}{$val}</div>";
        }
    };

    echo "<div class='dd-wrapper'><div class='dd-header'>Called in <strong>{$file}</strong>:<strong>{$line}</strong></div>";
    $render($data);
    echo "</div>";
    die();
}