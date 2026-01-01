<?php
namespace App\Controllers;

require_once __DIR__ . '/../Models/Absensi.php';
require_once __DIR__ . '/../Models/Kelas.php';
require_once __DIR__ . '/../Models/Guru.php';
require_once __DIR__ . '/Controller.php';

use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Kelas;

class ValidasiController extends Controller
{
    public function __construct()
    {
        // Must be logged in
        if (! isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    // Dashboard for Validation
    public function index()
    {
        // 1. Identify Guru
        // Assuming role 'Guru' is needed
        if ($_SESSION['role'] !== 'Guru') {
            // Or maybe Admin can see all? But logic is per class.
            // For Admin, maybe redirect to a different view or show all?
            // Let's stick to Wali Kelas logic first.
            $this->redirect('dashboard')->with('error', 'Hanya Guru/Wali Kelas.');
            exit;
        }

        $guru = Guru::findByUserId($_SESSION['user_id']);
        if (! $guru) {
            $this->redirect('dashboard')->with('error', 'Data Guru tidak ditemukan.');
            exit;
        }

        // 2. Find Managed Class
        $kelas = Kelas::getByWaliKelas($guru['guru_id']);
        if (! $kelas) {
            // Not a wali kelas
            $this->view('akademik/validasi/index', [
                'title'       => 'Validasi Absensi',
                'isWaliKelas' => false,
                'pending'     => [],
            ]);
            return;
        }

        // 3. Get Pending Absensi
        $pending = Absensi::getPendingByKelas($kelas['kelas_id']);

        $data = [
            'title'       => 'Validasi Absensi - Kelas ' . $kelas['nama_kelas'],
            'isWaliKelas' => true,
            'kelas'       => $kelas,
            'pending'     => $pending,
        ];

        $this->view('akademik/validasi/index', $data);
    }

    // Show Details (and Approve/Reject form)
    public function detail()
    {
        $id = $_GET['id'] ?? null;
        if (! $id) {
            $this->redirect('validasi');
            exit;
        }

        $absensi = Absensi::findWithDetails($id);
        if (! $absensi) {
            $this->redirect('validasi')->with('error', 'Data absensi tidak ditemukan.');
            exit;
        }

        $details = Absensi::getDetails($id);

        $data = [
            'title'   => 'Detail Validasi Absensi',
            'absensi' => $absensi,
            'details' => $details,
        ];

        $this->view('akademik/validasi/detail', $data);
    }

    // Process Approval
    public function approve()
    {
        $absensi_id = $_POST['absensi_id'];
        $action     = $_POST['action']; // 'approve' or 'reject'

        if (! $absensi_id || ! $action) {
            $this->redirect('validasi')->with('error', 'Data tidak valid.');
            exit;
        }

        $status = ($action === 'approve') ? 'Valid' : 'Rejected';

        $result = Absensi::update($absensi_id, [
            'status_validasi'  => $status,
            'alasan_penolakan' => $action === 'reject' ? $_POST['alasan_penolakan'] : null,
        ]);

        if ($result['status']) {
            $this->redirect('validasi')->with('success', 'Status absensi berhasil diperbarui menjadi ' . $status);
        } else {
            $this->redirect('validasi')->with('error', 'Gagal memperbarui status: ' . $result['message']);
        }
    }
}