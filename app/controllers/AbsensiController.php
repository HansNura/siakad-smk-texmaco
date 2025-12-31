<?php
namespace App\Controllers;

require_once __DIR__ . '/../Models/Absensi.php';
require_once __DIR__ . '/../Models/Jadwal.php';
require_once __DIR__ . '/../Models/Siswa.php';
require_once __DIR__ . '/../Models/TahunAjaran.php';
require_once __DIR__ . '/../Models/Guru.php';
require_once __DIR__ . '/Controller.php';

use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Siswa;
use App\Models\TahunAjaran;

class AbsensiController extends Controller
{
    public function __construct()
    {
        // Must be logged in
        if (! isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        // Ideally check role = Guru or Admin
    }

    // Show today's schedule for the teacher
    public function create()
    {
        // 1. Determine active Academic Year
        $activeTahun = TahunAjaran::getActive();
        if (! $activeTahun) {
            echo "Belum ada Tahun Ajaran aktif.";
            return;
        }

        // 2. Identify the Guru
        // Assuming user_id is in session. detailed role check needed.
        // For now, assume if role is 'Guru', we find Guru record by user_id
        $guru_id = null;
        if ($_SESSION['role'] === 'Guru') {
            $guru = Guru::findByUserId($_SESSION['user_id']);
            if ($guru) {
                $guru_id = $guru['guru_id'];
            }
        } elseif ($_SESSION['role'] === 'Admin') {
            // Admin can see all? Or simulate?
            // For now, let's just say Admin can't input attendance or needs to pick a teacher.
            // But usually this view is for the logged in teacher.
            $this->redirect('dashboard')->with('error', 'Fitur ini khusus Guru.');
            exit;
        }

        if (! $guru_id) {
            // Handle error: User is not linked to a Guru record
            $this->redirect('dashboard')->with('error', 'Data Guru tidak ditemukan.');
            exit;
        }

        // 3. Determine Day
        $hariArr = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];
        $todayEnglish = date('l');
        $hariIni      = $hariArr[$todayEnglish] ?? 'Minggu';

        // 4. Fetch Schedules
        $jadwal = Jadwal::getByGuru($guru_id, $hariIni, $activeTahun['tahun_id']);

        // Check submission status for each schedule
        foreach ($jadwal as &$j) {
            $existing            = Absensi::checkExisting($j['jadwal_id'], date('Y-m-d'));
            $j['status_absensi'] = $existing ? $existing['status_validasi'] : 'Belum Input';
            $j['absensi_id']     = $existing ? $existing['absensi_id'] : null;
        }

        $data = [
            'title'   => 'Input Absensi - ' . $hariIni . ', ' . date('d M Y'),
            'jadwal'  => $jadwal,
            'hari'    => $hariIni,
            'tanggal' => date('Y-m-d'),
        ];

        $this->view('akademik/absensi/create', $data);
    }

    // Show Input Form
    public function input()
    {
        $jadwal_id = $_GET['jadwal_id'] ?? null;
        if (! $jadwal_id) {
            $this->redirect('absensi/create');
            exit;
        }

        $jadwal = Jadwal::findWithDetails($jadwal_id);
        if (! $jadwal) {
            $this->redirect('absensi/create')->with('error', 'Jadwal tidak ditemukan');
            exit;
        }

        // Cek existing
        $existing = Absensi::checkExisting($jadwal_id, date('Y-m-d'));
        if ($existing) {
            // If already exists, maybe redirect to view/edit?
            // specific logic can be added here.
            // For now, prevent double input.
            $this->redirect('absensi/create')->with('info', 'Absensi sudah diinput. Status: ' . $existing['status_validasi']);
            exit;
        }

        // Fetch Students
        $siswa = Siswa::getByKelas($jadwal['kelas_id']);

        $data = [
            'title'   => 'Form Absensi: ' . $jadwal['nama_kelas'] . ' - ' . $jadwal['nama_mapel'],
            'jadwal'  => $jadwal,
            'siswa'   => $siswa,
            'tanggal' => date('Y-m-d'),
        ];

        $this->view('akademik/absensi/input', $data);
    }

    // Store Attendance
    public function store()
    {
        $jadwal_id = $_POST['jadwal_id'];
        $tanggal   = $_POST['tanggal']; // Usually curdate
        $catatan   = $_POST['catatan_harian'] ?? '';
        $status    = $_POST['status_kehadiran'] ?? []; // Array of siswa_id => status

        if (empty($status)) {
            $this->redirect('absensi/input?jadwal_id=' . $jadwal_id)->with('error', 'Tidak ada data siswa.');
            exit;
        }

        $detailsData = [];
        foreach ($status as $siswa_id => $st) {
            $detailsData[] = [
                'siswa_id'         => $siswa_id,
                'status_kehadiran' => $st,
            ];
        }

        $headerData = [
            'jadwal_id'      => $jadwal_id,
            'tanggal'        => $tanggal,
            'catatan_harian' => $catatan,
        ];

        $model  = new Absensi();
        $result = $model->createWithDetail($headerData, $detailsData);

        if ($result['status']) {
            $this->redirect('absensi/create')->with('success', 'Absensi berhasil disimpan.');
        } else {
            $this->redirect('absensi/input?jadwal_id=' . $jadwal_id)->with('error', $result['message']);
        }
    }
}
