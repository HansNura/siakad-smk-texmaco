<?php

if (!function_exists('redirect')) {
    function redirect($path)
    {
        return new class($path) {
            private $path;
            private $flash = [];

            public function __construct($path)
            {
                $this->path = $path;
            }

            public function with($key, $message)
            {
                // Simpan data flash sementara di properti object
                $this->flash = ['type' => $key, 'message' => $message];
                
                // Return $this agar bisa chaining (berantai)
                return $this; 
            }

            /**
             * Destructor akan otomatis dijalankan saat object selesai digunakan.
             * Ini trik agar kita tidak perlu panggil method ->send() atau ->go() manual.
             */
            public function __destruct()
            {
                // 1. Set Session jika ada data flash
                if (!empty($this->flash)) {
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['flash'] = $this->flash;
                }

                // 2. Lakukan Redirect
                // Pastikan BASE_URL sudah didefinisikan di config.php
                header("Location: " . BASE_URL . $this->path);
                exit;
            }
        };
    }
}