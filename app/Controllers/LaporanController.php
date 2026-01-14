<?php
namespace App\Controllers;

require_once __DIR__ . "/../Models/Rapor.php";
require_once __DIR__ . "/../Models/Siswa.php";
require_once __DIR__ . "/../Models/Kelas.php";
require_once __DIR__ . "/../Models/TahunAjaran.php";
require_once __DIR__ . "/../Models/Guru.php";
require_once __DIR__ . "/Controller.php";

use App\Models\Rapor;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Guru;

class LaporanController extends Controller
{
    // Halaman List Siswa untuk Wali Kelas
    public function index()
    {
        $activeTahun = TahunAjaran::getActive();
        if (!$activeTahun) {
            $this->redirect('dashboard')->with('error', 'Tahun ajaran belum aktif.');
            exit;
        }

        // Cek Guru & Kelas Wali
        $guru = Guru::where('user_id', $_SESSION['user_id'])->first();
        if (!$guru) {
            $this->redirect('dashboard'); 
            exit;
        }

        $kelas = Kelas::getByWaliKelas($guru['guru_id']);
        
        if (!$kelas) {
             // Tampilkan view kosong jika bukan wali kelas
             $this->view('akademik/rapor/index', [
                'title' => 'Rapor Siswa',
                'isWaliKelas' => false,
                'list' => []
            ]);
            return;
        }

        // Ambil Siswa di kelas tersebut
        $siswaList = Siswa::getByKelas($kelas['kelas_id']);
        $listData = [];

        foreach ($siswaList as $s) {
            // Cek apakah catatan sudah diisi?
            $catatan = Rapor::getCatatan($s['siswa_id'], $activeTahun['tahun_id']);
            
            $listData[] = [
                'siswa' => $s,
                'status_catatan' => $catatan ? 'Sudah Diisi' : 'Belum Diisi',
                // Logika status nilai bisa ditambahkan di sini jika perlu
            ];
        }

        $data = [
            'title' => 'Rapor - Kelas ' . $kelas['nama_kelas'],
            'isWaliKelas' => true,
            'kelas' => $kelas,
            'activeTahun' => $activeTahun,
            'list' => $listData
        ];

        $this->view('akademik/rapor/index', $data);
    }

    // Form Input Catatan (Sikap & Akademik)
    public function inputCatatan()
    {
        $siswa_id = $_GET['id'] ?? null;
        if (!$siswa_id) { $this->redirect('rapor'); exit; }

        $activeTahun = TahunAjaran::getActive();
        $biodata = Rapor::getBiodata($siswa_id);
        
        // Ambil data existing jika ada (untuk edit)
        $catatan = Rapor::getCatatan($siswa_id, $activeTahun['tahun_id']);

        $data = [
            'title' => 'Input Catatan Rapor',
            'biodata' => $biodata,
            'catatan' => $catatan,
            'tahun' => $activeTahun
        ];

        $this->view('akademik/rapor/input_catatan', $data);
    }

    // Proses Simpan Catatan
    public function storeCatatan()
    {
        $activeTahun = TahunAjaran::getActive();
        $guru = Guru::where('user_id', $_SESSION['user_id'])->first();

        $data = [
            'siswa_id' => $_POST['siswa_id'],
            'tahun_id' => $activeTahun['tahun_id'],
            'guru_wali_id' => $guru['guru_id'],
            'catatan_sikap' => $_POST['catatan_sikap'],
            'catatan_akademik' => $_POST['catatan_akademik']
        ];

        if (Rapor::saveCatatan($data)) {
            $this->redirect('rapor')->with('success', 'Catatan rapor berhasil disimpan.');
        } else {
            $this->redirect('rapor/catatan?id='.$_POST['siswa_id'])->with('error', 'Gagal menyimpan catatan.');
        }
    }

    // Cetak Rapor (PDF View)
    public function print()
    {
        $siswa_id = $_GET['id'] ?? null;
        if (!$siswa_id) { $this->redirect('rapor'); exit; }

        $activeTahun = TahunAjaran::getActive();

        // 1. Ambil Data Lengkap
        $biodata = Rapor::getBiodata($siswa_id);
        $nilai   = Rapor::getNilaiAkademik($siswa_id, $activeTahun['tahun_id']);
        $absensi = Rapor::getAbsensi($siswa_id, $activeTahun['tahun_id']);
        $catatan = Rapor::getCatatan($siswa_id, $activeTahun['tahun_id']);

        if (!$catatan) {
            $this->redirect('rapor')->with('error', 'Mohon isi Catatan Wali Kelas terlebih dahulu sebelum mencetak.');
            exit;
        }

        // 2. Catat Log (History)
        Rapor::logPrint($_SESSION['user_id'], $siswa_id, 'Rapor');

        $data = [
            'title' => 'Rapor ' . $biodata['nama_lengkap'],
            'biodata' => $biodata,
            'nilai' => $nilai,
            'absensi' => $absensi,
            'catatan' => $catatan,
            'tahun' => $activeTahun
        ];

        // Tampilkan view cetak (biasanya view ini hanya berisi HTML table sederhana + window.print())
        $this->view('akademik/rapor/cetak', $data);
    }
}
