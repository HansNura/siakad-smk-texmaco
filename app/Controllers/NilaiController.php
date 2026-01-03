
<?php

namespace App\Controllers;

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/Jadwal.php';
require_once __DIR__ . '/../Models/TahunAjaran.php';
require_once __DIR__ . '/../Models/Siswa.php';
require_once __DIR__ . '/../Models/Nilai.php';
require_once __DIR__ . '/../Models/Kelas.php';
require_once __DIR__ . '/../Models/Mapel.php';

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\TahunAjaran;

class NilaiController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Guru') {
            $this->redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            exit;
        }
    }

    public function create()
    {
        $guru_id = $_SESSION['user']['guru_id'];
        
        if (!isset($_SESSION['tahun_ajaran_aktif'])) {
            $this->redirect('/dashboard')->with('error', 'Tidak ada tahun ajaran yang aktif saat ini.');
            return;
        }
        
        $tahun_id = $_SESSION['tahun_ajaran_aktif']['tahun_id'];

        $this->view('nilai/create', [
            'title' => 'Input Nilai - Pilih Kelas & Mata Pelajaran',
            'jadwal' => Jadwal::getKelasMapelByGuru($guru_id, $tahun_id)
        ]);
    }

    public function input()
    {
        if (!isset($_GET['kelas_id']) || !isset($_GET['mapel_id'])) {
            $this->redirect('/nilai/create')->with('error', 'Parameter kelas atau mata pelajaran tidak valid.');
            return;
        }

        $kelas_id = $_GET['kelas_id'];
        $mapel_id = $_GET['mapel_id'];
        $tahun_id = $_SESSION['tahun_ajaran_aktif']['tahun_id'];

        $kelas = Kelas::find($kelas_id);
        $mapel = Mapel::find($mapel_id);

        if (!$kelas || !$mapel) {
            $this->redirect('/nilai/create')->with('error', 'Data kelas atau mapel tidak ditemukan.');
            return;
        }
        
        $this->view('nilai/input', [
            'title' => "Input Nilai - " . $kelas['nama_kelas'] . " - " . $mapel['nama_mapel'],
            'kelas' => $kelas,
            'mapel' => $mapel,
            'siswa' => Siswa::getByKelas($kelas_id),
            'nilai' => Nilai::getByKelasMapel($kelas_id, $mapel_id, $tahun_id),
            'kelas_id' => $kelas_id,
            'mapel_id' => $mapel_id
        ]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/');
            return;
        }

        $kelas_id = $_POST['kelas_id'];
        $mapel_id = $_POST['mapel_id'];
        $tahun_id = $_POST['tahun_id'];
        $nilaiData = $_POST['nilai'];

        $dataToSave = [];
        foreach ($nilaiData as $siswa_id => $nilai) {
            $dataToSave[] = [
                'siswa_id' => $siswa_id,
                'mapel_id' => $mapel_id,
                'tahun_id' => $tahun_id,
                'tugas'    => !empty($nilai['tugas']) ? $nilai['tugas'] : 0,
                'uts'      => !empty($nilai['uts']) ? $nilai['uts'] : 0,
                'uas'      => !empty($nilai['uas']) ? $nilai['uas'] : 0,
            ];
        }

        if (Nilai::saveBatch($dataToSave)) {
            $this->redirect("/nilai/input?kelas_id={$kelas_id}&mapel_id={$mapel_id}")->with('success', 'Nilai berhasil disimpan.');
        } else {
            $this->redirect("/nilai/input?kelas_id={$kelas_id}&mapel_id={$mapel_id}")->with('error', 'Gagal menyimpan nilai.');
        }
    }
}
