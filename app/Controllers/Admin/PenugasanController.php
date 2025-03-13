<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\PegawaiModel;
use App\Models\PenugasanModel;
use App\Models\UnitkerjaModel;
use App\Models\NotificationModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DataException;
use Config\Database;
use Config\PenugasanConfig;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use DateTime;
use Exception;

/**
 * Class PenugasanController
 *
 * @package App\Controllers
 */
class PenugasanController extends BaseController
{
    use ResponseTrait;

    protected $PenugasanModel;
    protected $PegawaiModel;
    protected $JadwalModel;
    protected $UnitkerjaModel;
    protected $NotificationModel;
    protected $db;
    protected $config;
    protected $helpers = ['status', 'form', 'url', 'auth', 'encrypt'];  // Menambahkan helper encrypt

    public function __construct()
    {
        $this->PenugasanModel = new PenugasanModel();
        $this->PegawaiModel = new PegawaiModel();
        $this->JadwalModel = new JadwalModel();
        $this->UnitkerjaModel = new UnitkerjaModel();
        $this->NotificationModel = new NotificationModel();
        $this->db = Database::connect();
        $this->config = new PenugasanConfig();
    }

    public function index()
    {
        $penugasanModel = new PenugasanModel();
        $pegawaiModel = new PegawaiModel();
        $unitKerjaModel = new UnitKerjaModel();

        $pegawai_id = session()->get('pegawai_id');
        $role = session()->get('role_id');

        // Get logged in employee data
        $data_pegawai = $pegawaiModel->where('id', $pegawai_id)->first();
        if (!$data_pegawai) {
            return redirect()->to('/login')->with('error', 'Data pegawai tidak ditemukan.');
        }

        // Get unit data based on role
        if ($role == 1 || $role == 2) {
            // Admin dan Kepala Unit dapat melihat semua unit eselon 1
            $unit_eselon_1 = $unitKerjaModel->where('parent_id', 1)
                ->where("nama_unit_kerja NOT LIKE '%staf ahli bidang%'", null, false)
                ->findAll();
        } else if ($role == 3) {
            // Koordinator can only view their own eselon 1 unit
            $unit_pegawai = $unitKerjaModel->where('id', $data_pegawai['unit_kerja_id'])->first();
            if ($unit_pegawai) {
                $unit_eselon_1 = $unitKerjaModel
                    ->where('id', $unit_pegawai['parent_id'])
                    ->where('parent_id', 1)
                    ->where("nama_unit_kerja NOT LIKE '%staf ahli bidang%'", null, false)
                    ->findAll();
            } else {
                $unit_eselon_1 = [];
            }
        } else {
            $unit_eselon_1 = [];
        }

        // Check for new proposals from ES 1 units
        $newProposals = [];
        if (!empty($unit_eselon_1)) {
            $unitIds = array_column($unit_eselon_1, 'id');
            
            $newProposals = $penugasanModel
                ->select('usulan.*, pegawai.nama as nama_pengusul, unit_kerja.nama_unit_kerja as nama_unit,unit_kerja.id as unit_kerja_id, parent_unit.id as parent_unit_id, parent_unit.nama_unit_kerja as parent_unit_name')
                ->join('pegawai', 'pegawai.id = usulan.upload_by')
                ->join('unit_kerja', 'unit_kerja.id = pegawai.unit_kerja_id')
                ->join('unit_kerja as parent_unit', 'unit_kerja.parent_id = parent_unit.id')
                ->where('usulan.status_approval', 1) // Only pending proposals
                ->whereIn('parent_unit.id', $unitIds) // Only from ES 1 units in the list
                ->orderBy('usulan.created_at', 'DESC') // Show newest first
                ->findAll();
        }

        $data = [
            'unit_eselon_1' => $unit_eselon_1,
            'role' => $role,
            'title' => 'Kelola Penugasan',
            'data_pegawai' => $data_pegawai,
            'new_proposals' => $newProposals
        ];

        // dd($data);

        return view('admin/penugasan/index', $data);
    }

    public function daftar_unit($id)
    {
        try {
            // Decrypt the ID
            $decrypted_id = decrypt_url($id);

            $usulanModel = new PenugasanModel();
            $pegawaiModel = new PegawaiModel();
            $unitKerjaModel = new UnitKerjaModel();

            $sessionPegawaiId = session('pegawai_id');
            $roleId = session('role_id');

            if (!$sessionPegawaiId) {
                return redirect()->to(base_url('auth'));
            }

            // Ambil data unit kerja yang sedang dilihat
            $unit_kerja = $unitKerjaModel->find($decrypted_id);
            if (!$unit_kerja) {
                return redirect()->back()->with('error', 'Unit kerja tidak ditemukan.');
            }

            // Ambil data pegawai beserta unit kerjanya
            $pegawai = $pegawaiModel->find($sessionPegawaiId);
            if (!$pegawai) {
                return redirect()->back()->with('error', 'Data pegawai tidak ditemukan.');
            }

            $pegawaiUnitKerja = $unitKerjaModel->find($pegawai['unit_kerja_id']);
            if (!$pegawaiUnitKerja) {
                return redirect()->back()->with('error', 'Unit kerja pegawai tidak ditemukan.');
            }

            // Jika role 3 dan berada di Sekretariat Kemenko PMK (id = 2)
            if ($roleId == 3 && $pegawaiUnitKerja['parent_id'] == 2) {
                // Jika melihat parent unit (Sekretariat Kemenko PMK)
                if ($decrypted_id == 2) {
                    // Tampilkan hanya biro yang sesuai dengan unit kerja pegawai
                    $unit_eselon_2 = $unitKerjaModel->where('id', $pegawai['unit_kerja_id'])->findAll();
                    return view('admin/penugasan/daftar_unit', [
                        'title' => 'Daftar Unit Eselon 2',
                        'unit_eselon_2' => $unit_eselon_2,
                        'parent_unit' => $unit_kerja
                    ]);
                }

                // Hanya bisa melihat unit kerjanya sendiri
                if ($decrypted_id != $pegawai['unit_kerja_id']) {
                    return redirect()->back()->with('error', 'Anda hanya dapat melihat data unit kerja Anda sendiri.');
                }
            }

            // Jika unit id atau parent_id adalah 2 dan role adalah 1 atau 2, tampilkan daftar unit
            if (($roleId == 1 || $roleId == 2) && ($decrypted_id == 2)) {
                $unit_eselon_2 = $unitKerjaModel->where('parent_id', $decrypted_id)->findAll();

                // Log untuk debugging
                log_message('debug', 'Unit Eselon 2 query: ' . print_r($unit_eselon_2, true));

                return view('admin/penugasan/daftar_unit', [
                    'title' => 'Daftar Unit Eselon 2',
                    'unit_eselon_2' => $unit_eselon_2,
                    'parent_unit' => $unit_kerja
                ]);
            }

            $query = $usulanModel
                ->select('usulan.*, pegawai.nama as nama_pengusul, unit_kerja.nama_unit_kerja as nama_unit, catatan_usulan.catatan as catatan_penolakan')
                ->join('pegawai', 'pegawai.id = usulan.upload_by')
                ->join('unit_kerja', 'unit_kerja.id = pegawai.unit_kerja_id')
                ->join('catatan_usulan', 'catatan_usulan.id = usulan.catatan_id', 'left');

            // Filter berdasarkan role
            if ($roleId == 1 || $roleId == 2) {
                // Admin dan Kepala Unit dapat melihat semua usulan dalam unit yang dipilih
                if ($unit_kerja['parent_id'] == 2) {
                    // Jika melihat unit eselon 2, tampilkan usulan dari unit tersebut
                    $query->where('pegawai.unit_kerja_id', $decrypted_id);
                } else {
                    // Jika melihat unit eselon 1, tampilkan usulan dari semua unit di bawahnya
                    $query
                        ->join('unit_kerja as parent_unit', 'unit_kerja.parent_id = parent_unit.id')
                        ->where('parent_unit.id', $decrypted_id);
                }
                
                // Untuk role 1 dan 2, tampilkan usulan dengan status_approval bukan 0
                $query->where('usulan.status_approval !=', 0);
            } elseif ($roleId == 3) {
                // Koordinator Unit
                $pegawaiUnitKerja = $unitKerjaModel->find($pegawai['unit_kerja_id']);
                if ($pegawaiUnitKerja && $pegawaiUnitKerja['parent_id'] == 2) {
                    // Jika koordinator berada di unit kerja dengan parent_id = 2
                    // Hanya bisa melihat usulan dari unitnya sendiri
                    $query->where('pegawai.unit_kerja_id', $pegawai['unit_kerja_id']);
                } else {
                    // Koordinator unit lain hanya melihat usulan dari unitnya
                    $query->where('pegawai.unit_kerja_id', $pegawai['unit_kerja_id']);
                }
            } else {
                // Role lain hanya melihat usulan miliknya
                $query->where('usulan.upload_by', $sessionPegawaiId);
            }

            $usulan = $query->findAll();

            return view('admin/penugasan/daftar_usulan', [
                'title' => 'Daftar Usulan',
                'usulan' => $usulan,
                'unit_kerja' => $unit_kerja,
                'role_id' => $roleId,
                'pegawai_id' => $sessionPegawaiId
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in daftar_unit: ' . $e->getMessage());
            return redirect()->to('admin/penugasan')->with('error', 'Terjadi kesalahan saat memproses data: ' . $e->getMessage());
        }
    }

    public function daftar_usulan($id)
    {
        try {
            // Decrypt the ID
            $decrypted_id = decrypt_url($id);

            $usulanModel = new PenugasanModel();
            $pegawaiModel = new PegawaiModel();
            $unitKerjaModel = new UnitKerjaModel();

            $sessionPegawaiId = session('pegawai_id');
            $roleId = session('role_id');

            if (!$sessionPegawaiId) {
                return redirect()->to(base_url('auth'));
            }

            // Ambil data unit kerja yang sedang dilihat
            $unit_kerja = $unitKerjaModel->find($decrypted_id);
            if (!$unit_kerja) {
                return redirect()->back()->with('error', 'Unit kerja tidak ditemukan.');
            }

            // Ambil data pegawai beserta unit kerjanya
            $pegawai = $pegawaiModel->find($sessionPegawaiId);
            if (!$pegawai) {
                return redirect()->back()->with('error', 'Data pegawai tidak ditemukan.');
            }

            $pegawaiUnitKerja = $unitKerjaModel->find($pegawai['unit_kerja_id']);
            if (!$pegawaiUnitKerja) {
                return redirect()->back()->with('error', 'Unit kerja pegawai tidak ditemukan.');
            }

            // Jika role 3 dan berada di Sekretariat Kemenko PMK (id = 2)
            if ($roleId == 3 && $pegawaiUnitKerja['parent_id'] == 2) {
                // Jika melihat parent unit (Sekretariat Kemenko PMK)
                if ($decrypted_id == 2) {
                    // Tampilkan hanya biro yang sesuai dengan unit kerja pegawai
                    $unit_eselon_2 = $unitKerjaModel->where('id', $pegawai['unit_kerja_id'])->findAll();
                    return view('admin/penugasan/daftar_unit', [
                        'title' => 'Daftar Unit Eselon 2',
                        'unit_eselon_2' => $unit_eselon_2,
                        'parent_unit' => $unit_kerja
                    ]);
                }

                // Hanya bisa melihat unit kerjanya sendiri
                if ($decrypted_id != $pegawai['unit_kerja_id']) {
                    return redirect()->back()->with('error', 'Anda hanya dapat melihat data unit kerja Anda sendiri.');
                }
            }

            // Jika unit id atau parent_id adalah 2 dan role adalah 1 atau 2, tampilkan daftar unit
            if (($roleId == 1 || $roleId == 2) && $decrypted_id == 2) {
                $unit_eselon_2 = $unitKerjaModel->where('parent_id', $decrypted_id)->findAll();
                return view('admin/penugasan/daftar_unit', [
                    'title' => 'Daftar Unit Eselon 2',
                    'unit_eselon_2' => $unit_eselon_2,
                    'parent_unit' => $unit_kerja
                ]);
            }

            $query = $usulanModel
                ->select('usulan.*, pegawai.nama as nama_pengusul, unit_kerja.nama_unit_kerja as nama_unit, catatan_usulan.catatan as catatan_penolakan')
                ->join('pegawai', 'pegawai.id = usulan.upload_by')
                ->join('unit_kerja', 'unit_kerja.id = pegawai.unit_kerja_id')
                ->join('catatan_usulan', 'catatan_usulan.id = usulan.catatan_id', 'left');

            // Filter berdasarkan role
            if ($roleId == 1 || $roleId == 2) {
                // Admin dan Kepala Unit dapat melihat semua usulan dalam unit yang dipilih
                if ($unit_kerja['parent_id'] == 2) {
                    // Jika melihat unit eselon 2, tampilkan usulan dari unit tersebut
                    $query->where('pegawai.unit_kerja_id', $decrypted_id);
                } else {
                    // Jika melihat unit eselon 1, tampilkan usulan dari semua unit di bawahnya
                    $query
                        ->join('unit_kerja as parent_unit', 'unit_kerja.parent_id = parent_unit.id')
                        ->where('parent_unit.id', $decrypted_id);
                }
                
                // Untuk role 1 dan 2, tampilkan usulan dengan status_approval bukan 0
                $query->where('usulan.status_approval !=', 0);
            } elseif ($roleId == 3) {
                // Koordinator Unit
                $pegawaiUnitKerja = $unitKerjaModel->find($pegawai['unit_kerja_id']);
                if ($pegawaiUnitKerja && $pegawaiUnitKerja['parent_id'] == 2) {
                    // Jika koordinator berada di unit kerja dengan parent_id = 2
                    // Hanya bisa melihat usulan dari unitnya sendiri
                    $query->where('pegawai.unit_kerja_id', $pegawai['unit_kerja_id']);
                } else {
                    // Koordinator unit lain hanya melihat usulan dari unitnya
                    $query->where('pegawai.unit_kerja_id', $pegawai['unit_kerja_id']);
                }
            } else {
                // Role lain hanya melihat usulan miliknya
                $query->where('usulan.upload_by', $sessionPegawaiId);
            }

            $usulan = $query->findAll();

            return view('admin/penugasan/daftar_usulan', [
                'title' => 'Daftar Usulan - ' . $unit_kerja['nama_unit_kerja'],
                'usulan' => $usulan,
                'unit_kerja' => $unit_kerja,
                'role_id' => $roleId,
                'pegawai_id' => $sessionPegawaiId
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in daftar_usulan: ' . $e->getMessage());
            return redirect()->to('admin/penugasan')->with('error', 'Terjadi kesalahan saat memproses data: ' . $e->getMessage());
        }
    }

    public function daftar_usulan_koordinator($unit_kerja_id = null)
    {
        $usulanModel = new PenugasanModel();
        $pegawaiModel = new PegawaiModel();
        $unitKerjaModel = new UnitKerjaModel();

        $sessionPegawaiId = session('pegawai_id');
        $roleId = session('role_id');

        if (!$sessionPegawaiId || $roleId != 3) {
            return redirect()->to(base_url('auth'));
        }

        // Ambil data pegawai dan unit kerjanya
        $pegawai = $pegawaiModel->find($sessionPegawaiId);
        if (!$pegawai) {
            return redirect()->back()->with('error', 'Data pegawai tidak ditemukan');
        }

        // Jika unit_kerja_id tidak diberikan, gunakan unit kerja koordinator
        if (!$unit_kerja_id) {
            $unit_kerja_id = $pegawai['unit_kerja_id'];
        }

        // Ambil data unit kerja
        $unit_kerja = $unitKerjaModel->find($unit_kerja_id);
        if (!$unit_kerja) {
            return redirect()->back()->with('error', 'Unit kerja tidak ditemukan.');
        }

        // Pastikan koordinator hanya bisa melihat data unit kerjanya sendiri
        if ($unit_kerja_id != $pegawai['unit_kerja_id']) {
            return redirect()->back()->with('error', 'Anda hanya dapat melihat data unit kerja Anda sendiri.');
        }

        // Ambil usulan berdasarkan unit kerja
        $query = $usulanModel
            ->select('usulan.*, pegawai.nama as nama_pengusul, unit_kerja.nama_unit_kerja as nama_unit, catatan_usulan.catatan as catatan_penolakan')
            ->join('pegawai', 'pegawai.id = usulan.upload_by')
            ->join('unit_kerja', 'unit_kerja.id = pegawai.unit_kerja_id')
            ->join('catatan_usulan', 'catatan_usulan.id = usulan.catatan_id', 'left')
            ->where('pegawai.unit_kerja_id', $unit_kerja_id);

        $usulan = $query->findAll();

        return view('admin/penugasan/daftar_usulan', [
            'title' => 'Daftar Usulan Unit ' . $unit_kerja['nama_unit_kerja'],
            'usulan' => $usulan,
            'unit_kerja' => $unit_kerja,
            'role_id' => $roleId,
            'pegawai_id' => $sessionPegawaiId
        ]);
    }

    public function editJadwal($id)
    {
        try {
            // Decrypt the ID
            $decrypted_id = decrypt_url($id);

            $penugasanModel = new PenugasanModel();
            $pegawaiModel = new PegawaiModel();
            $usulanData = $penugasanModel->find($decrypted_id);

            if (!$usulanData) {
                return redirect()->to(site_url('admin/penugasan'))->with('error', 'Usulan tidak ditemukan');
            }

            // Get the uploader's unit data
            $uploaderData = $pegawaiModel
                ->select('pegawai.*, unit_kerja.parent_id')
                ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id')
                ->where('pegawai.id', $usulanData['upload_by'])
                ->first();

            // Get pegawai list based on uploader's unit
            $unitKerjaModel = new UnitKerjaModel();
            
            if ($uploaderData['parent_id'] == 2) {
                // For units directly under Sekretariat Kementerian (parent_id = 2)
                // Get all employees from this unit and its sub-units
                $unitId = $uploaderData['unit_kerja_id'];
                $childUnitIds = $unitKerjaModel->getAllChildUnits($unitId);
                
                // Include the current unit in the list
                $allUnitIds = array_merge([$unitId], $childUnitIds);
                
                $data_pegawai_unit = $pegawaiModel
                    ->select('pegawai.*, unit_kerja.nama_unit_kerja, jabatan.nama_jabatan, jabatan.eselon, jabatan.tipe_jabatan')
                    ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id')
                    ->join('jabatan', 'pegawai.jabatan_id = jabatan.id', 'left')
                    ->whereIn('pegawai.unit_kerja_id', $allUnitIds)
                    ->orderBy('FIELD(jabatan.tipe_jabatan, "Struktural", "Fungsional", "PPPK", "Pelaksana", NULL)', '', false) // Sort in specified order
                    ->orderBy('jabatan.eselon', 'ASC') // Then sort by eselon from I.a to IV.a
                     
                    ->findAll();
            } else {
                // For other units, get pegawai with same parent_id
                $data_pegawai_unit = $pegawaiModel
                    ->select('pegawai.*, unit_kerja.nama_unit_kerja, jabatan.nama_jabatan, jabatan.eselon, jabatan.tipe_jabatan')
                    ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id')
                    ->join('jabatan', 'pegawai.jabatan_id = jabatan.id', 'left')
                    ->where('unit_kerja.parent_id', $uploaderData['parent_id'])
                    ->orderBy('FIELD(jabatan.tipe_jabatan, "Struktural", "Fungsional", "PPPK", "Pelaksana", NULL)', '', false) // Sort in specified order
                    ->orderBy('jabatan.eselon', 'ASC') // Then sort by eselon from I.a to IV.a
                    
                    ->findAll();
            }

            $role_id = session()->get('role_id');

            // Get status label and class
            $status_label = '';
            $status_class = '';
            switch ($usulanData['status_approval']) {
                case 0:
                    $status_label = 'Draft';
                    $status_class = 'bg-secondary';
                    break;
                case 1:
                    $status_label = 'Menunggu Persetujuan';
                    $status_class = 'bg-warning';
                    break;
                case 2:
                    $status_label = 'Disetujui';
                    $status_class = 'bg-success';
                    break;
                case 3:
                    $status_label = 'Ditolak';
                    $status_class = 'bg-danger';
                    break;
                case 4:
                    $status_label = 'Dibatalkan';
                    $status_class = 'bg-info';
                    break;
            }

            $usulanBulan = $usulanData['bulan'];
            $usulan = explode('-', $usulanBulan);

            $tahun = $usulan[0];
            $bulan = $usulan[1];

            $data = [
                'title' => 'Edit Jadwal',
                'data_pegawai_unit' => $data_pegawai_unit,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'status_approval' => $usulanData['status_approval'],
                'status_label' => $status_label,
                'status_class' => $status_class,
                'role_id' => $role_id,
                'usulan_id' => $decrypted_id
            ];

            return view('admin/penugasan/editjadwal', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error in editJadwal: ' . $e->getMessage());
            return redirect()->to('admin/penugasan')->with('error', 'Terjadi kesalahan saat memproses data');
        }
    }

    private function getEventClass($jenis_alokasi)
    {
        switch ($jenis_alokasi) {
            case 'LKK':
                return 'bg-primary';
            case 'LKL':
                return 'bg-success';
            case 'CT':
                return 'bg-purple';
            default:
                return 'bg-info';
        }
    }

    public function getJadwalTersedia($usulan_id)
    {
        try {
            // Set CORS headers to allow AJAX requests
            $this->response->setHeader('Access-Control-Allow-Origin', '*');
            $this->response->setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
            $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

            // Handle preflight OPTIONS request
            if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
                return $this->response->setStatusCode(200);
            }

            $pegawai_id = $this->request->getGet('pegawai_id');
            $bulan = $this->request->getGet('bulan');
            $tahun = $this->request->getGet('tahun');

            if (!$pegawai_id || !$bulan || !$tahun) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Parameter tidak lengkap'
                ]);
            }

            $jadwalModel = new JadwalModel();
            $jadwal = $jadwalModel->where([
                'usulan_id' => $usulan_id,
                'pegawai_id' => $pegawai_id,
                'MONTH(tanggal_kerja)' => $bulan,
                'YEAR(tanggal_kerja)' => $tahun
            ])->findAll();

            return $this->response->setJSON([
                'success' => true,
                'data' => $jadwal
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in getJadwalTersedia: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data jadwal'
            ]);
        }
    }

    public function createUsulan()
    {
        $pegawaiModel = new PegawaiModel();
        $unitKerjaModel = new UnitKerjaModel();

        $pegawai_id = session()->get('pegawai_id');

        // **Ambil unit kerja pegawai yang login**
        $pegawai = $pegawaiModel->where('id', $pegawai_id)->first();
        if (!$pegawai) {
            return redirect()->back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        $unit_id = $pegawai['unit_kerja_id'];
        $unit_kerja = $unitKerjaModel->where('id', $unit_id)->first();

        if (!$unit_kerja) {
            return redirect()->back()->with('error', 'Unit kerja tidak ditemukan.');
        }

        // **Cek apakah unit kerja pegawai termasuk dalam eselon 1 (`parent_id = 2`)**
        if ($unit_kerja['parent_id'] == 2) {
            // Jika `parent_id = 2`, hanya tampilkan pegawai dalam unit kerja tersebut
            $data_pegawai_unit = $pegawaiModel->where('unit_kerja_id', $unit_id)->findAll();
        } else {
            // Jika `parent_id != 2`, tampilkan semua pegawai dalam unit kerja dengan `parent_id` yang sama
            $data_pegawai_unit = $pegawaiModel
                ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id')
                ->where('unit_kerja.parent_id', $unit_kerja['parent_id'])
                ->findAll();
        }

        $data = [
            'data_pegawai_unit' => $data_pegawai_unit
        ];

        return view('admin/penugasan/create_usulan', $data);
    }

    public function createJadwal()
    {
        $pegawaiModel = new PegawaiModel();
        $unitKerjaModel = new UnitKerjaModel();

        $pegawai_id = session()->get('pegawai_id');

        // **Ambil unit kerja pegawai yang login**
        $pegawai = $pegawaiModel->where('id', $pegawai_id)->first();
        if (!$pegawai) {
            return redirect()->back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        $unit_id = $pegawai['unit_kerja_id'];
        $unit_kerja = $unitKerjaModel->where('id', $unit_id)->first();

        if (!$unit_kerja) {
            return redirect()->back()->with('error', 'Unit kerja tidak ditemukan.');
        }

        // **Cek apakah unit kerja pegawai termasuk dalam eselon 1 (`parent_id = 2`)**
        if ($unit_kerja['parent_id'] == 2) {
            // Jika `parent_id = 2`, tampilkan pegawai dari unit kerja tersebut dan sub-unitnya
            $childUnitIds = $unitKerjaModel->getAllChildUnits($unit_id);
            $allUnitIds = array_merge([$unit_id], $childUnitIds);
            
            $data_pegawai_unit = $pegawaiModel
                ->select('pegawai.*, unit_kerja.nama_unit_kerja, jabatan.nama_jabatan, jabatan.eselon, jabatan.tipe_jabatan')
                ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id')
                ->join('jabatan', 'pegawai.jabatan_id = jabatan.id', 'left')
                ->whereIn('pegawai.unit_kerja_id', $allUnitIds)
                ->orderBy('FIELD(jabatan.tipe_jabatan, "Struktural", "Fungsional", "PPPK", "Pelaksana", NULL)', '', false) // Sort in specified order
                ->orderBy('jabatan.eselon', 'ASC') // Then sort by eselon from I.a to IV.a
                ->orderBy('pegawai.nama', 'ASC')   // Then sort by name
                ->findAll();
        } else {
            // Jika `parent_id != 2`, tampilkan semua pegawai dalam unit kerja dengan `parent_id` yang sama
            $data_pegawai_unit = $pegawaiModel
                ->select('pegawai.*, unit_kerja.nama_unit_kerja, jabatan.nama_jabatan, jabatan.eselon, jabatan.tipe_jabatan')
                ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id')
                ->join('jabatan', 'pegawai.jabatan_id = jabatan.id', 'left')
                ->where('unit_kerja.parent_id', $unit_kerja['parent_id'])
                ->orderBy('FIELD(jabatan.tipe_jabatan, "Struktural", "Fungsional", "PPPK", "Pelaksana", NULL)', '', false) // Sort in specified order
                ->orderBy('jabatan.eselon', 'ASC') // Then sort by eselon from I.a to IV.a
                ->orderBy('pegawai.nama', 'ASC')   // Then sort by name
                ->findAll();
        }

        $data = [
            'data_pegawai_unit' => $data_pegawai_unit
        ];

        return view('admin/penugasan/create', $data);
    }

    public function storeUsulan()
    {
        try {
            $jadwalModel = new JadwalModel();
            $usulanModel = new PenugasanModel();
            $pegawaiModel = new PegawaiModel();
            $hariLiburModel = new \App\Models\HariLiburModel(); // Add HariLiburModel
            $sessionPegawaiId = session('pegawai_id');

            if (!$sessionPegawaiId) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Session pegawai tidak ditemukan.']);
            }

            // ** Ambil data dari form **
            $bulanPengajuan = $this->request->getPost('bulan');
            $tahunPengajuan = $this->request->getPost('tahun');
            $fileSurat = $this->request->getFile('file_surat');
            $fileExcel = $this->request->getFile('file_excel');
            $bulanTahun = $tahunPengajuan . '-' . $bulanPengajuan;
            $tanggalSekarang = date('d');

            if (!$bulanPengajuan || !$tahunPengajuan) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Bulan dan tahun harus diisi.']);
            }

            // ** Cek apakah sudah ada pengajuan untuk bulan ini **
            $existingUsulan = $usulanModel
                ->where('upload_by', $sessionPegawaiId)
                ->where('bulan', $bulanTahun)
                ->first();

            if ($existingUsulan) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Pengajuan untuk bulan ini sudah ada. Anda harus membatalkan pengajuan sebelumnya sebelum mengajukan yang baru.'
                ]);
            }

            // ** Validasi file surat **
            if (!$fileSurat || !$fileSurat->isValid()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'File surat wajib diunggah.']);
            }

            if ($fileSurat->getClientMimeType() !== 'application/pdf' || $fileSurat->getSize() > 2097152) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'File surat harus berupa PDF dan maksimal 2MB.']);
            }

            // ** Validasi file Excel **
            if (!$fileExcel || !$fileExcel->isValid()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'File jadwal kerja (Excel) wajib diunggah.']);
            }

            if ($fileExcel->getClientExtension() !== 'xlsx' || $fileExcel->getSize() > 2097152) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'File Excel harus dalam format .xlsx dan maksimal 2MB.']);
            }

            // Ambil semua tanggal libur dari database
            $holidays = $hariLiburModel->findAll();
            $holidayDates = array_column($holidays, 'tanggal');

            // ** Baca dan validasi file Excel terlebih dahulu **
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($fileExcel->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            if (count($rows) <= 1) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'File Excel kosong atau hanya berisi header.']);
            }

            $insertData = [];
            $errors = [];
            $uniqueNips = [];
            $nipTanggalCombinations = [];

            // Skip header row
            array_shift($rows);

            foreach ($rows as $index => $row) {
                if (empty(array_filter($row)))
                    continue;

                $nip = trim((string) $row[1]);
                $tanggal = trim((string) $row[2]);
                $jenis_alokasi = strtoupper(trim((string) $row[3]));
                $baris = $index + 2;

                // Validasi NIP
                if (empty($nip)) {
                    $errors[] = "Baris {$baris}: NIP tidak boleh kosong";
                    continue;
                }

                // Cari pegawai berdasarkan NIP
                $pegawai = $pegawaiModel->where('nip', $nip)->first();
                if (!$pegawai) {
                    $errors[] = "Baris {$baris}: NIP {$nip} tidak terdaftar dalam database";
                    continue;
                }

                // Validasi format tanggal
                $date = DateTime::createFromFormat('Y-m-d', $tanggal);
                if (!$date || $date->format('Y-m-d') !== $tanggal) {
                    $errors[] = "Baris {$baris}: Format tanggal tidak valid (gunakan format YYYY-MM-DD)";
                    continue;
                }

                // Skip hari weekend tanpa error
                $dayOfWeek = (int) $date->format('N');
                if ($dayOfWeek >= 6) {  // 6 = Sabtu, 7 = Minggu
                    continue;  // Lewati data weekend tanpa menambahkan error
                }

                // Skip hari libur dari tabel hari_libur tanpa error
                if (in_array($tanggal, $holidayDates)) {
                    continue;  // Lewati tanggal yang termasuk hari libur tanpa menambahkan error
                }

                // Validasi bulan kerja sama dengan bulan pengajuan
                if ($date->format('m') !== $bulanPengajuan) {
                    $errors[] = "Baris {$baris}: Tanggal kerja harus sesuai bulan pengajuan";
                    continue;
                }

                // Validasi jenis alokasi
                if (!in_array($jenis_alokasi, ['LKK', 'LKL', 'CT'])) {
                    $errors[] = "Baris {$baris}: Jenis alokasi tidak valid (harus LKK, LKL, atau CT)";
                    continue;
                }

                // Validasi hari Senin harus LKK
                // if ($dayOfWeek == 1 && $jenis_alokasi == 'LKL') {
                //     $errors[] = "Baris {$baris}: Hari Senin hanya boleh LKK, tidak boleh LKL";
                //     continue;
                // }

                // Validasi duplikasi NIP dan tanggal
                $nipTanggalKey = $nip . '_' . $tanggal;
                if (isset($nipTanggalCombinations[$nipTanggalKey])) {
                    $errors[] = "Baris {$baris}: Pegawai dengan NIP {$nip} sudah memiliki jadwal {$nipTanggalCombinations[$nipTanggalKey]} pada tanggal {$tanggal}";
                    continue;
                }
                $nipTanggalCombinations[$nipTanggalKey] = $jenis_alokasi;

                // Tambahkan NIP ke array untuk validasi jumlah hari kerja
                if (!isset($uniqueNips[$nip])) {
                    $uniqueNips[$nip] = [];
                }
                $uniqueNips[$nip][] = $tanggal;

                // Simpan data valid
                $insertData[] = [
                    'pegawai_id' => $pegawai['id'],
                    'tanggal_kerja' => $tanggal,
                    'jenis_alokasi' => $jenis_alokasi
                ];
            }

            if (!empty($errors)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => implode('<br>', $errors)
                ]);
            }

            // Jika tidak ada data valid untuk diinsert
            if (empty($insertData)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Tidak ada data valid untuk disimpan dalam file Excel.'
                ]);
            }

            // ** Mulai transaksi database **
            $db = \Config\Database::connect();
            $db->transStart();

            // ** Upload file surat **
            $fileName = $fileSurat->getRandomName();
            $fileSurat->move(ROOTPATH . 'public/uploads/data_dukung', $fileName);

            // ** Insert ke tabel Usulan **
            $usulanData = [
                'bulan' => $bulanTahun,
                'upload_by' => $sessionPegawaiId,
                'file_surat' => $fileName,
                'status_approval' => 0,
            ];

            try {
                $usulanId = $usulanModel->insert($usulanData, true);

                // Update usulan_id di data jadwal
                foreach ($insertData as &$data) {
                    $data['usulan_id'] = $usulanId;
                }

                $jadwalModel->insertBatch($insertData);

                $db->transComplete();

                if ($db->transStatus() === false) {
                    throw new \Exception('Gagal menyimpan data.');
                }

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Data berhasil disimpan.',
                    'redirect' => base_url('admin/penugasan/editjadwal/' . encrypt_url((string) $usulanId))
                ]);
            } catch (\Exception $e) {
                $db->transRollback();
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function storeJadwal()
    {
        $jadwalModel = new JadwalModel();
        $usulanModel = new PenugasanModel();
        $sessionPegawaiId = session('pegawai_id');

        if (!$sessionPegawaiId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Session pegawai tidak ditemukan.']);
        }

        // Ambil data dari request
        $jadwalData = json_decode($this->request->getPost('jadwal'), true);
        $deletedJadwalData = json_decode($this->request->getPost('deleted_jadwal'), true);
        $statusApproval = $this->request->getPost('status_approval');

        if (!is_array($jadwalData) || empty($jadwalData)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Jadwal tidak ditemukan.']);
        }

        // **Ambil bulan dari tanggal pertama dalam jadwal**
        $firstJadwal = $jadwalData[0];
        $bulanPengajuan = date('Y-m', strtotime($firstJadwal['tanggal_kerja']));

        // **Cek apakah sudah ada pengajuan usulan untuk bulan ini**
        $existingUsulan = $usulanModel
            ->where('upload_by', $sessionPegawaiId)
            ->where('bulan', $bulanPengajuan)
            ->first();

        if ($existingUsulan) {
            $usulanId = $existingUsulan['id'];
        } else {
            // Jika belum ada, buat usulan baru
            $usulanId = $usulanModel->insert([
                'bulan' => $bulanPengajuan,
                'upload_by' => $sessionPegawaiId,
                'status_approval' => $statusApproval
            ], true);
        }

        // **Looping untuk menyimpan atau memperbarui jadwal**
        foreach ($jadwalData as $jadwal) {
            if (!isset($jadwal['pegawai_id']) || !isset($jadwal['tanggal_kerja']) || !isset($jadwal['jenis_alokasi'])) {
                continue;  // Lewati jika data tidak lengkap
            }

            $existingJadwal = $jadwalModel
                ->where('pegawai_id', $jadwal['pegawai_id'])
                ->where('tanggal_kerja', $jadwal['tanggal_kerja'])
                ->first();

            if ($existingJadwal) {
                // Update jika ada perubahan jenis alokasi
                if ($existingJadwal['jenis_alokasi'] !== $jadwal['jenis_alokasi']) {
                    $jadwalModel->update($existingJadwal['id'], [
                        'jenis_alokasi' => $jadwal['jenis_alokasi'],
                        'usulan_id' => $usulanId
                    ]);
                }
            } else {
                // Insert baru jika belum ada
                $jadwalModel->insert([
                    'pegawai_id' => $jadwal['pegawai_id'],
                    'tanggal_kerja' => $jadwal['tanggal_kerja'],
                    'jenis_alokasi' => $jadwal['jenis_alokasi'],
                    'usulan_id' => $usulanId
                ]);
            }
        }

        // **Hapus jadwal yang dihapus dari kalender**
        if (!empty($deletedJadwalData) && is_array($deletedJadwalData)) {
            foreach ($deletedJadwalData as $deletedId) {
                $jadwalModel->delete($deletedId);
            }
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Jadwal berhasil disimpan.', 'redirect' => 'reload']);
    }

    public function ajukanUsulan()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request method']);
        }

        $usulan_id = decrypt_url($this->request->getPost('usulan_id'));

        if (!$usulan_id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter tidak valid']);
        }

        // Validasi periode pengajuan
        // if (!$this->isWithinSubmissionPeriod()) {
        //     return $this->response->setJSON([
        //         'status' => 'error',
        //         'message' => sprintf(
        //             'Pengajuan hanya dapat dilakukan dari tanggal %d hingga %d setiap bulannya. Jika tanggal %d jatuh pada hari Sabtu atau Minggu, pengajuan dapat dilakukan hingga hari Senin berikutnya.',
        //             $this->config->tanggalMulaiPengajuan,
        //             $this->config->tanggalAkhirPengajuan,
        //             $this->config->tanggalAkhirPengajuan
        //         )
        //     ]);
        // }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Update status in usulan table
            $result = $this->PenugasanModel->update($usulan_id, [
                'status_approval' => 1
            ]);

            if (!$result) {
                throw new \Exception('Gagal mengupdate status usulan');
            }

            // Update status in jadwal table for all related entries
            $result = $this
                ->JadwalModel
                ->where('usulan_id', $usulan_id)
                ->set([
                    'status_approval' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ])
                ->update();

            if ($result === false) {
                throw new \Exception('Gagal mengupdate status jadwal');
            }

            if ($db->transStatus() === false) {
                throw new \Exception('Gagal mengupdate status');
            }

            // Get the unit_kerja_id for the user who submitted the proposal
            $usulanData = $this->PenugasanModel->find($usulan_id);
            $pegawaiModel = new PegawaiModel();
            $pegawai = $pegawaiModel->find($usulanData['upload_by']);
            $redirect_unit_id = $pegawai['unit_kerja_id'];

            // Return success response
            $db->transCommit();
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Usulan berhasil diajukan',
                'redirect' => base_url('admin/penugasan/editjadwal/' . encrypt_url((string) $usulan_id))
            ]);
        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function batalkanUsulan()
    {
        $usulanModel = new PenugasanModel();
        $sessionPegawaiId = session('pegawai_id');

        if (!$sessionPegawaiId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Session pegawai tidak ditemukan.']);
        }

        // Cari usulan yang sedang diajukan
        $usulan = $usulanModel
            ->where('upload_by', $sessionPegawaiId)
            ->where('status_approval', 1)  // Cari usulan yang sedang diajukan
            ->first();

        if (!$usulan) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tidak ada usulan yang bisa dibatalkan.'
            ]);
        }

        try {
            // Update status_approval menjadi 4 (dibatalkan)
            $usulanModel->update($usulan['id'], ['status_approval' => 4]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Usulan telah dibatalkan.',
                'usulan_id' => $usulan['id'],
                'redirect' => 'reload'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function updateStatus()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request method']);
        }

        $usulan_id = decrypt_url($this->request->getPost('usulan_id'));
        $status = $this->request->getPost('status');
        $catatan_penolakan = $this->request->getPost('catatan_penolakan');

        if (!$usulan_id || !is_numeric($usulan_id) || !in_array($status, [0, 2, 3, 4])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter tidak valid']);
        }

        // For rejection, catatan_penolakan is required
        if ($status == 3 && empty($catatan_penolakan)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Catatan penolakan harus diisi']);
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $catatan_id = null;
            
            // Step 1: Always save to catatan_usulan table first if there's a catatan
            if (!empty($catatan_penolakan)) {
                // Insert catatan
                $db->query("INSERT INTO catatan_usulan (usulan_id, catatan, created_at, updated_at) VALUES (?, ?, NOW(), NOW())", [
                    $usulan_id, 
                    $catatan_penolakan
                ]);
                
                // Get the last inserted ID
                $catatan_id = $db->insertID();

                if (!$catatan_id) {
                    throw new \Exception('Gagal menyimpan catatan penolakan');
                }
                
                // Log for debugging
                log_message('info', 'Catatan saved with ID: ' . $catatan_id . ' for usulan ID: ' . $usulan_id);
            }

            // Step 2: Update usulan table with status and catatan_id if available
            if ($catatan_id) {
                // Update with catatan_id
                $db->query("UPDATE usulan SET status_approval = ?, catatan_id = ?, updated_at = NOW() WHERE id = ?", [
                    $status,
                    $catatan_id,
                    $usulan_id
                ]);
                
                // Log for debugging
                log_message('info', 'Updated usulan ID: ' . $usulan_id . ' with status: ' . $status . ' and catatan_id: ' . $catatan_id);
            } else {
                // Update without catatan_id
                $this->PenugasanModel->update($usulan_id, [
                    'status_approval' => $status
                ]);
                
                // Log for debugging
                log_message('info', 'Updated usulan ID: ' . $usulan_id . ' with status: ' . $status . ' (no catatan)');
            }

            // Step 3: Update status in jadwal table for all related entries
            $this->JadwalModel
                ->where('usulan_id', $usulan_id)
                ->set([
                    'status_approval' => $status
                ])
                ->update();

            if ($db->transStatus() === false) {
                throw new \Exception('Gagal mengupdate status');
            }

            $db->transCommit();
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Status berhasil diupdate',
                'redirect' => 'reload'
            ]);
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error updating status: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @deprecated Use updateStatus instead
     */
    public function terimaUsulan()
    {
        // This method is deprecated
        // Please use updateStatus with status=2 instead
        return $this->response->setJSON(['status' => 'error', 'message' => 'Method deprecated, use updateStatus instead']);
    }

    /**
     * @deprecated Use updateStatus instead
     */
    public function tolakUsulan()
    {
        // This method is deprecated
        // Please use updateStatus with status=3 instead
        return $this->response->setJSON(['status' => 'error', 'message' => 'Method deprecated, use updateStatus instead']);
    }

    public function validateExcel()
    {
        try {
            $jadwalModel = new JadwalModel();
            $pegawaiModel = new PegawaiModel();
            $unitKerjaModel = new UnitKerjaModel();
            $hariLiburModel = new \App\Models\HariLiburModel(); // Add HariLiburModel
            $sessionPegawaiId = session('pegawai_id');

            if (!$sessionPegawaiId) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Session pegawai tidak ditemukan.'
                ]);
            }

            // Ambil data pegawai dan unit kerjanya
            $pegawai = $pegawaiModel->where('id', $sessionPegawaiId)->first();
            if (!$pegawai) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data pegawai tidak ditemukan.'
                ]);
            }

            $unitKerjaPengusul = $pegawai['unit_kerja_id'];

            // Ambil data unit kerja pengusul
            $unitKerja = $unitKerjaModel->find($unitKerjaPengusul);
            if (!$unitKerja) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Unit kerja tidak ditemukan.'
                ]);
            }

            // Validasi file Excel
            $fileExcel = $this->request->getFile('file_excel');
            if (!$fileExcel->isValid()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'File Excel tidak valid.'
                ]);
            }

            // Ambil bulan pengajuan dari form
            $bulanPengajuan = $this->request->getPost('bulan');
            if (!$bulanPengajuan) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Bulan pengajuan harus diisi.'
                ]);
            }

            $tahun = date('Y');
            $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulanPengajuan, $tahun);

            // Ambil semua tanggal libur dari database
            $holidays = $hariLiburModel->findAll();
            $holidayDates = array_column($holidays, 'tanggal');

            // Baca file Excel
            $reader = new Xlsx();
            $spreadsheet = $reader->load($fileExcel->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            array_shift($rows);  // Skip header

            $errors = [];
            $uniqueNips = [];
            $dataExcel = [];
            $nipTanggalCombinations = [];

            foreach ($rows as $key => $row) {
                // Skip jika semua kolom kosong
                if (empty(array_filter($row)))
                    continue;

                // Pastikan array memiliki minimal 4 elemen
                if (count($row) < 4)
                    continue;

                // Ambil dan validasi data dari Excel
                $nip = trim((string) $row[1]);
                $tanggalKerja = trim((string) $row[2]);
                $jenisAlokasi = strtoupper(trim((string) $row[3]));
                $baris = $key + 2;

                if (empty($nip) || empty($tanggalKerja) || empty($jenisAlokasi)) {
                    continue;
                }

                // Validasi format tanggal
                $date = DateTime::createFromFormat('Y-m-d', $tanggalKerja);
                if (!$date || $date->format('Y-m-d') !== $tanggalKerja) {
                    $errors[] = "Baris {$baris}: Format tanggal tidak valid (gunakan format YYYY-MM-DD)";
                    continue;
                }

                $tanggalNumeric = (int) $date->format('d');
                if ($tanggalNumeric > $jumlahHari) {
                    $errors[] = "Baris {$baris}: Tanggal kerja ({$tanggalKerja}) melebihi jumlah hari dalam bulan ini (maks {$jumlahHari} hari)";
                    continue;
                }
                // Skip hari weekend tanpa error
                $dayOfWeek = (int) $date->format('N');
                if ($dayOfWeek >= 6) {  // 6 = Sabtu, 7 = Minggu
                    continue;
                }

                // Skip hari libur dari tabel hari_libur tanpa error
                if (in_array($tanggalKerja, $holidayDates)) {
                    // Skip tanggal yang termasuk hari libur tanpa menambahkan error
                    continue;
                }

                // Validasi NIP (18 digit angka)
                if (!preg_match('/^[0-9]{18}$/', $nip)) {
                    $errors[] = "Baris {$baris}: Format NIP tidak valid";
                    continue;
                }

                // Validasi NIP ada di database
                $pegawai = $pegawaiModel->where('nip', $nip)->first();
                if (!$pegawai) {
                    $errors[] = "Baris {$baris}: NIP tidak terdaftar";
                    continue;
                }

                // Validasi status pegawai aktif
                if ($pegawai['status_pegawai'] != 1) {
                    // Skip pegawai yang tidak aktif tanpa menampilkan error
                    continue;
                }

                // Validasi unit kerja pegawai
                if ($unitKerja['parent_id'] == 2) {
                    // Untuk eselon 1, pegawai bisa dari unit kerja yang sama atau sub-unitnya
                    $unitKerjaModel = new UnitKerjaModel();
                    $childUnitIds = $unitKerjaModel->getAllChildUnits($unitKerjaPengusul);
                    
                    $allowedUnitIds = array_merge([$unitKerjaPengusul], $childUnitIds);
                    
                    if (!in_array($pegawai['unit_kerja_id'], $allowedUnitIds)) {
                        $errors[] = "Baris {$baris}: NIP {$nip} ({$pegawai['nama']}) bukan dari unit kerja yang sama atau sub-unitnya";
                        continue;
                    }
                } else {
                    // Untuk unit kerja lain, cek parent_id harus sama
                    $unitKerjaPegawai = $unitKerjaModel->find($pegawai['unit_kerja_id']);
                    if ($unitKerjaPegawai['parent_id'] != $unitKerja['parent_id']) {
                        $errors[] = "Baris {$baris}: NIP {$nip} ({$pegawai['nama']}) bukan dari unit kerja yang sama";
                        continue;
                    }
                }

                // Validasi bulan kerja sama dengan bulan pengajuan
                if ($date->format('m') !== $bulanPengajuan) {
                    $errors[] = "Baris {$baris}: Tanggal kerja harus sesuai bulan pengajuan";
                    continue;
                }

                // Validasi jenis alokasi
                if (!in_array($jenisAlokasi, ['LKK', 'LKL', 'CT'])) {
                    $errors[] = "Baris {$baris}: Jenis alokasi tidak valid (harus LKK, LKL, atau CT)";
                    continue;
                }

                // Validasi hari Senin harus LKK
                // if ($dayOfWeek == 1 && $jenisAlokasi == 'LKL') {
                //     $errors[] = "Baris {$baris}: Hari Senin hanya boleh LKK, tidak boleh LKL";
                //     continue;
                // }

                // Validasi duplikasi NIP dan tanggal
                $nipTanggalKey = $nip . '_' . $tanggalKerja;
                if (isset($nipTanggalCombinations[$nipTanggalKey])) {
                    $errors[] = "Baris {$baris}: NIP {$nip} sudah memiliki jadwal {$nipTanggalCombinations[$nipTanggalKey]} pada tanggal {$tanggalKerja}";
                    continue;
                }
                $nipTanggalCombinations[$nipTanggalKey] = $jenisAlokasi;

                // Cek apakah jadwal sudah ada di database
                $existingJadwal = $jadwalModel
                    ->join('usulan', 'usulan.id = jadwal.usulan_id')
                    ->where('jadwal.pegawai_id', $pegawai['id'])
                    ->where('jadwal.tanggal_kerja', $tanggalKerja)
                    ->where('usulan.status_approval !=', 2) // Tidak termasuk yang ditolak
                    ->first();
                
                if ($existingJadwal) {
                    $errors[] = "Baris {$baris}: NIP {$nip} ({$pegawai['nama']}) sudah memiliki jadwal pada tanggal {$tanggalKerja} di database";
                    continue;
                }

                // Tambahkan NIP ke array untuk validasi jumlah hari kerja
                if (!in_array($nip, $uniqueNips)) {
                    $uniqueNips[] = $nip;
                }

                // Tambahkan data ke array untuk diinsert
                $dataExcel[] = [
                    'nip' => $nip,
                    'tanggal' => $tanggalKerja,
                    'jenis_alokasi' => $jenisAlokasi,
                    'baris' => $baris
                ];
            }

            // Ambil semua pegawai dalam unit kerja yang sama sampai hirarki parent_id = 1
            $query = $pegawaiModel
                ->select('pegawai.*, unit_kerja.parent_id')
                ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id');

            // Jika unit kerja pengusul memiliki parent_id = 2 (eselon 1)
            if ($unitKerja['parent_id'] == 2) {
                $query->where('pegawai.unit_kerja_id', $unitKerjaPengusul);
            } else {
                // Ambil semua pegawai dalam unit kerja dengan parent_id yang sama
                $query->where('unit_kerja.parent_id', $unitKerja['parent_id']);
            }

            $allPegawai = $query->findAll();

            // Cek pegawai yang tidak ada di Excel
            $missingPegawai = [];
            foreach ($allPegawai as $p) {
                if (!in_array($p['nip'], $uniqueNips)) {
                    $missingPegawai[] = "{$p['nama']} (NIP: {$p['nip']})";
                }
            }

            if (!empty($missingPegawai)) {
                $errorMsg = 'Pegawai berikut belum terdapat dalam Excel:<br>- ';
                $errorMsg .= implode('<br>- ', $missingPegawai);
                $errors[] = $errorMsg;
            }

            log_message('debug', 'Validation errors: ' . json_encode($errors));
            if (!empty($errors)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => implode('<br>', $errors)
                ]);
            }

            // Setelah loop pertama selesai, cek kelengkapan jadwal untuk setiap pegawai
            if (empty($errors)) {
                // Dapatkan semua hari kerja dalam bulan pengajuan
                $tahun = date('Y');
                $workingDays = $this->getWorkingDaysInMonth($tahun, $bulanPengajuan);

                // Array untuk menyimpan jadwal per pegawai
                $jadwalPegawai = [];

                // Inisialisasi array jadwal untuk setiap pegawai
                foreach ($uniqueNips as $nip) {
                    $jadwalPegawai[$nip] = [];
                }

                // Isi jadwal dari data Excel yang sudah divalidasi
                foreach ($dataExcel as $data) {
                    $jadwalPegawai[$data['nip']][] = $data['tanggal'];
                }

                // Cek kelengkapan jadwal setiap pegawai
                // Validasi ini dinonaktifkan - tidak lagi memeriksa apakah pegawai memiliki jadwal untuk semua hari kerja
                // foreach ($uniqueNips as $nip) {
                //     $pegawai = $pegawaiModel->where('nip', $nip)->first();
                //     $jadwalTerdaftar = $jadwalPegawai[$nip];
                //     $hariKurang = array_diff($workingDays, $jadwalTerdaftar);

                //     if (!empty($hariKurang)) {
                //         $tanggalKurang = implode(', ', $hariKurang);
                //         $errors[] = "NIP {$nip} ({$pegawai['nama']}) belum memiliki jadwal untuk tanggal: {$tanggalKurang}";
                //     }
                // }
            }

            if (!empty($errors)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => implode('<br>', $errors)
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'File Excel valid',
                'redirect' => 'reload'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function checkCompleteSchedule()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $usulan_id = $this->request->getPost('usulan_id');
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        if (!$usulan_id || !$bulan || !$tahun) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter tidak lengkap']);
        }

        try {
            // Get the list of employees for this usulan
            $data_pegawai = $this
                ->db
                ->table('jadwal')
                ->select('pegawai.id, pegawai.nama')
                ->join('pegawai', 'pegawai.id = jadwal.pegawai_id')
                ->where('jadwal.usulan_id', $usulan_id)
                ->groupBy('pegawai.id')
                ->get()
                ->getResultArray();

            $incomplete_employees = [];

            foreach ($data_pegawai as $pegawai) {
                // Get all dates in the month excluding weekends
                $start_date = "{$tahun}-{$bulan}-01";
                $end_date = date('Y-m-t', strtotime($start_date));

                $workdays = [];
                $current = new DateTime($start_date);
                $last = new DateTime($end_date);

                while ($current <= $last) {
                    $dayOfWeek = $current->format('N');
                    if ($dayOfWeek < 6) {  // Monday = 1, Friday = 5
                        $workdays[] = $current->format('Y-m-d');
                    }
                    $current->modify('+1 day');
                }

                // Get scheduled dates for this employee
                $scheduled_dates = $this
                    ->db
                    ->table('jadwal')
                    ->select('tanggal_kerja')
                    ->where('pegawai_id', $pegawai['id'])
                    ->where('usulan_id', $usulan_id)
                    ->get()
                    ->getResultArray();

                $scheduled_dates = array_column($scheduled_dates, 'tanggal_kerja');

                // Calculate missing workdays
                $missing_days = array_diff($workdays, $scheduled_dates);

                if (count($missing_days) > 0) {
                    $incomplete_employees[] = [
                        'nama' => $pegawai['nama'],
                        'missing_days' => count($missing_days)
                    ];
                }
            }

            return $this->response->setJSON([
                'status' => 'success',
                'incomplete_employees' => $incomplete_employees
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    private function getWorkingDaysInMonth($year, $month)
    {
        $workingDays = [];
        $date = new DateTime("$year-$month-01");
        $lastDay = $date->format('t');

        // Load the holiday model
        $hariLiburModel = new \App\Models\HariLiburModel();

        // Get all holidays in this month
        $startDate = "$year-$month-01";
        $endDate = "$year-$month-$lastDay";
        $holidays = $hariLiburModel
            ->where('tanggal >=', $startDate)
            ->where('tanggal <=', $endDate)
            ->findAll();

        // Convert to simple array of dates for easier checking
        $holidayDates = [];
        foreach ($holidays as $holiday) {
            $holidayDates[] = $holiday['tanggal'];
        }

        for ($day = 1; $day <= $lastDay; $day++) {
            $date->setDate($year, $month, $day);
            $dayOfWeek = (int) $date->format('N');
            $currentDate = $date->format('Y-m-d');

            // Only include weekdays (Monday to Friday) that are not holidays
            if ($dayOfWeek < 6 && !in_array($currentDate, $holidayDates)) {
                $workingDays[] = $currentDate;
            }
        }

        return $workingDays;
    }

    /**
     * Check if a date is a holiday
     * 
     * @param string $date Date in Y-m-d format
     * @return array [isHoliday, holidayDescription]
     */
    private function isHoliday($date)
    {
        $hariLiburModel = new \App\Models\HariLiburModel();
        $holiday = $hariLiburModel->where('tanggal', $date)->first();

        if ($holiday) {
            return [true, $holiday['tentang']];
        }

        return [false, ''];
    }

    public function edit_usulan($id)
    {
        $decrypted_id = decrypt_url($id);
        if (!$decrypted_id) {
            return redirect()->to('/admin/penugasan')->with('error', 'ID tidak valid');
        }

        $pegawaiModel = new PegawaiModel();
        $unitKerjaModel = new UnitKerjaModel();
        $usulanModel = new PenugasanModel();
        $jadwalModel = new JadwalModel();

        // Get usulan data
        $usulan = $usulanModel->find($decrypted_id);
        if (!$usulan) {
            return redirect()->to('/admin/penugasan')->with('error', 'Usulan tidak ditemukan');
        }

        $pegawai_id = session()->get('pegawai_id');
        $role_id = session()->get('role_id');

        // Check access permissions based on status and role
        if ($usulan['status_approval'] == 2) {
            // For approved usulan (status 2), only view is allowed for all roles
            $can_edit = false;
        } else if ($usulan['status_approval'] == 3) {
            // For rejected usulan (status 3), only role 3 can edit
            $can_edit = ($role_id == 3);
        } else if ($usulan['status_approval'] == 0) {
            // For draft usulan (status 0), editing is allowed
            $can_edit = true;
        } else if ($usulan['status_approval'] == 1) {
            // For submitted usulan (status 1), only view is allowed
            $can_edit = false;
        } else {
            // For any other status, no editing is allowed
            $can_edit = false;
        }

        // Get pegawai data
        $pegawai = $pegawaiModel->where('id', $pegawai_id)->first();
        if (!$pegawai) {
            return redirect()->back()->with('error', 'Data pegawai tidak ditemukan');
        }

        $unit_id = $pegawai['unit_kerja_id'];
        $unit_kerja = $unitKerjaModel->where('id', $unit_id)->first();

        if (!$unit_kerja) {
            return redirect()->back()->with('error', 'Unit kerja tidak ditemukan');
        }

        // Get pegawai in unit
        if ($unit_kerja['parent_id'] == 2) {
            // If parent_id = 2, only show pegawai in that unit
            $data_pegawai_unit = $pegawaiModel->where('unit_kerja_id', $unit_id)->findAll();
        } else {
            // If parent_id != 2, show all pegawai in units with the same parent_id
            $data_pegawai_unit = $pegawaiModel
                ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id')
                ->where('unit_kerja.parent_id', $unit_kerja['parent_id'])
                ->findAll();
        }

        // Get bulan and tahun from usulan
        $bulanTahun = explode('-', $usulan['bulan']);
        $tahun = $bulanTahun[0];
        $bulan = $bulanTahun[1];

        $data = [
            'data_pegawai_unit' => $data_pegawai_unit,
            'usulan' => $usulan,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'role_id' => $role_id,
            'can_edit' => $can_edit
        ];

        return view('admin/penugasan/edit_usulan', $data);
    }

    public function updateUsulan($id)
    {
        try {
            $decrypted_id = decrypt_url($id);
            if (!$decrypted_id) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ID tidak valid']);
            }

            $jadwalModel = new JadwalModel();
            $usulanModel = new PenugasanModel();
            $pegawaiModel = new PegawaiModel();
            $unitKerjaModel = new UnitKerjaModel();
            $sessionPegawaiId = session('pegawai_id');
            $roleId = session('role_id');

            if (!$sessionPegawaiId) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Session pegawai tidak ditemukan.']);
            }

            // Get existing usulan
            $existingUsulan = $usulanModel->find($decrypted_id);
            if (!$existingUsulan) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Usulan tidak ditemukan']);
            }

            // Check edit permissions based on status and role
            $canEdit = false;
            if ($existingUsulan['status_approval'] == 0) {
                // Draft usulan can be edited
                $canEdit = true;
            } else if ($existingUsulan['status_approval'] == 3 && $roleId == 3) {
                // Rejected usulan can be edited by role 3 (koordinator)
                $canEdit = true;
            }

            if (!$canEdit) {
                $message = 'Usulan tidak dapat diedit pada status saat ini.';
                if ($existingUsulan['status_approval'] == 1) {
                    $message = 'Usulan yang sudah diajukan tidak dapat diedit.';
                } else if ($existingUsulan['status_approval'] == 2) {
                    $message = 'Usulan yang sudah disetujui tidak dapat diedit.';
                } else if ($existingUsulan['status_approval'] == 3) {
                    $message = 'Usulan yang sudah ditolak hanya dapat diedit oleh koordinator.';
                }
                return $this->response->setJSON(['status' => 'error', 'message' => $message]);
            }

            // Process file uploads if any
            $fileSurat = $this->request->getFile('file_surat');
            $fileExcel = $this->request->getFile('file_excel');

            // Data to update
            $updateData = [];

            // If status is rejected and being edited, reset status to draft
            if ($existingUsulan['status_approval'] == 3) {
                $updateData['status_approval'] = 0;
                $updateData['catatan_id'] = null; // Clear rejection note
            }

            // Process surat file if uploaded
            if ($fileSurat && $fileSurat->isValid()) {
                // Validate file type and size
                if ($fileSurat->getClientMimeType() !== 'application/pdf' || $fileSurat->getSize() > 2097152) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'File surat harus berupa PDF dan maksimal 2MB.']);
                }

                // Generate unique filename
                $newFileName = time() . '_' . $fileSurat->getRandomName();

                // Move file to uploads directory
                $fileSurat->move(ROOTPATH . 'public/uploads/data_dukung', $newFileName);

                // Update data with new file name
                $updateData['file_surat'] = $newFileName;

                // Delete old file if exists
                if (!empty($existingUsulan['file_surat'])) {
                    $oldFilePath = ROOTPATH . 'public/uploads/data_dukung/' . $existingUsulan['file_surat'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
            }

            // Process Excel file if uploaded
            if ($fileExcel && $fileExcel->isValid()) {
                // Validate file type and size
                if ($fileExcel->getClientExtension() !== 'xlsx' || $fileExcel->getSize() > 2097152) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'File Excel harus dalam format .xlsx dan maksimal 2MB.']);
                }

                // Validate Excel content
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($fileExcel->getTempName());
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();

                if (count($rows) <= 1) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'File Excel kosong atau hanya berisi header.']);
                }

                $insertData = [];
                $errors = [];
                $nipTanggalCombinations = [];
                $uniqueNips = [];

                // Get bulan and tahun from usulan
                $bulanTahun = explode('-', $existingUsulan['bulan']);
                $tahun = $bulanTahun[0];
                $bulan = $bulanTahun[1];

                foreach ($rows as $key => $row) {
                    if (empty(array_filter($row)))
                        continue;

                    // Pastikan array memiliki minimal 4 elemen
                    if (count($row) < 4)
                        continue;

                    // Ambil dan validasi data dari Excel
                    $nip = trim((string) $row[1]);
                    $tanggal = trim((string) $row[2]);
                    $jenis_alokasi = strtoupper(trim((string) $row[3]));
                    $baris = $key + 2;

                    if (empty($nip) || empty($tanggal) || empty($jenis_alokasi)) {
                        continue;
                    }

                    // Validasi format tanggal
                    $date = \DateTime::createFromFormat('Y-m-d', $tanggal);
                    if (!$date || $date->format('Y-m-d') !== $tanggal) {
                        $errors[] = "Baris {$baris}: Format tanggal tidak valid (gunakan format YYYY-MM-DD)";
                        continue;
                    }

                    // Skip hari weekend tanpa error
                    $dayOfWeek = (int) $date->format('N');
                    if ($dayOfWeek >= 6) {  // 6 = Saturday, 7 = Sunday
                        continue;
                    }

                    // Check if date is a holiday
                    list($isHoliday, $holidayInfo) = $this->isHoliday($tanggal);
                    if ($isHoliday) {
                        // Skip holiday dates without adding an error
                        continue;
                    }

                    // Validasi NIP (18 digits)
                    if (!preg_match('/^[0-9]{18}$/', $nip)) {
                        $errors[] = "Baris {$baris}: Format NIP tidak valid";
                        continue;
                    }

                    // Validasi NIP exists in database
                    $pegawai = $pegawaiModel->where('nip', $nip)->first();
                    if (!$pegawai) {
                        $errors[] = "Baris {$baris}: NIP tidak terdaftar";
                        continue;
                    }

                    // Tambahkan data ke array untuk diinsert
                    $insertData[] = [
                        'pegawai_id' => $pegawai['id'],
                        'tanggal_kerja' => $tanggal,
                        'jenis_alokasi' => $jenis_alokasi,
                        'usulan_id' => $decrypted_id
                    ];
                }

                if (!empty($errors)) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => implode('<br>', $errors)
                    ]);
                }

                // Only delete existing jadwal if we have valid data to insert
                if (!empty($insertData)) {
                    // Begin transaction
                    $db = \Config\Database::connect();
                    $db->transBegin();

                    try {
                        // Delete existing jadwal for this usulan
                        $jadwalModel->where('usulan_id', $decrypted_id)->delete();

                        // Insert new jadwal data
                        $jadwalModel->insertBatch($insertData);

                        // Commit transaction
                        $db->transCommit();
                    } catch (\Exception $e) {
                        // Rollback transaction on error
                        $db->transRollback();
                        return $this->response->setJSON([
                            'status' => 'error',
                            'message' => 'Terjadi kesalahan saat menyimpan jadwal: ' . $e->getMessage()
                        ]);
                    }
                }
            }

            // Update usulan if we have data to update
            if (!empty($updateData)) {
                $usulanModel->update($decrypted_id, $updateData);
            }

            // Log the successful update
            log_message('info', 'Usulan ID ' . $decrypted_id . ' berhasil diperbarui oleh pegawai ID ' . $sessionPegawaiId);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Usulan berhasil diperbarui',
                'redirect' => 'reload'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error updating usulan: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function generateExcelTemplate()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request method']);
        }

        $bulan = $this->request->getPost('bulan');
        
        if (!$bulan) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter bulan tidak valid']);
        }

        try {
            // Get current user's unit_kerja_id
            $pegawaiModel = new PegawaiModel();
            $unitkerjaModel = new UnitkerjaModel();
            $pegawai_id = session()->get('pegawai_id');
            $pegawaiData = $pegawaiModel->find($pegawai_id);
            
            if (!$pegawaiData) {
                throw new \Exception('Data pegawai tidak ditemukan');
            }
            
            $unit_kerja_id = $pegawaiData['unit_kerja_id'];
            $unit_kerja = $unitkerjaModel->find($unit_kerja_id);
            
            // Get all employees from the same unit and sub-units if applicable
            $employees = [];
            
            if ($unit_kerja['parent_id'] == 2) {
                // For eselon 1, include employees from the same unit and its sub-units
                $childUnitIds = $unitkerjaModel->getAllChildUnits($unit_kerja_id);
                $allowedUnitIds = array_merge([$unit_kerja_id], $childUnitIds);
                
                $employees = $pegawaiModel
                    ->select('pegawai.id, pegawai.nip, pegawai.nama, unit_kerja.nama_unit_kerja as unit_kerja_nama')
                    ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id')
                    ->whereIn('pegawai.unit_kerja_id', $allowedUnitIds)
                    ->where('pegawai.status_pegawai', 1) // Only active employees
                    ->orderBy('pegawai.nama', 'ASC')
                    ->findAll();
            } else {
                // For other units, get employees with the same parent_id
                $employees = $pegawaiModel
                    ->select('pegawai.id, pegawai.nip, pegawai.nama, unit_kerja.nama_unit_kerja as unit_kerja_nama')
                    ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id')
                    ->where('unit_kerja.parent_id', $unit_kerja['parent_id'])
                    ->where('pegawai.status_pegawai', 1) // Only active employees
                    ->orderBy('pegawai.nama', 'ASC')
                    ->findAll();
            }
            
            if (empty($employees)) {
                throw new \Exception('Tidak ada pegawai yang ditemukan di unit kerja ini');
            }
            
            // Get working days for the selected month
            $tahun = date('Y');
            $workingDays = $this->getWorkingDaysInMonth($tahun, $bulan);

            // Create Excel file
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set column headers
            $sheet->setCellValue('A1', 'nama_pegawai');
            $sheet->setCellValue('B1', 'nip_pegawai');
            $sheet->setCellValue('C1', 'tanggal_kerja');
            $sheet->setCellValue('D1', 'jenis_alokasi');
            
            // Style the header row
            $headerStyle = [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'DDEBF7',
                    ],
                ],
            ];
            $sheet->getStyle('A1:D1')->applyFromArray($headerStyle);
            
            // Add data validation for column D (JENIS KERJA)
            $validation = $sheet->getDataValidation('D2:D1000');
            $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $validation->setAllowBlank(false);
            $validation->setShowDropDown(true);
            $validation->setFormula1('"LKK,LKL,CT"');
            
            // Populate data
            $row = 2;
            
            foreach ($employees as $employee) {
                foreach ($workingDays as $day) {
                    // Alternate between LKK, LKL, CT for example purposes
                    $jenis_alokasi = 'LKK';
                    $dayIndex = ($row - 2) % 3;
                    if ($dayIndex == 1) {
                        $jenis_alokasi = 'LKL';
                    } else if ($dayIndex == 2) {
                        $jenis_alokasi = 'CT';
                    }
                    
                    $sheet->setCellValue('A' . $row, $employee['nama']);
                    
                    // Format NIP as text to preserve the full number
                    $sheet->setCellValueExplicit(
                        'B' . $row, 
                        $employee['nip'], 
                        \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
                    );
                    
                    $sheet->setCellValue('C' . $row, $day);
                    $sheet->setCellValue('D' . $row, $jenis_alokasi);
                    
                    $row++;
                }
            }
            
            // Auto-size columns
            foreach (range('A', 'D') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            // Create Excel file
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $filename = 'template_jadwal_' . date('Ymd_His') . '.xlsx';
            $filepath = WRITEPATH . 'uploads/temp/' . $filename;
            
            // Create directory if it doesn't exist
            if (!is_dir(WRITEPATH . 'uploads/temp/')) {
                mkdir(WRITEPATH . 'uploads/temp/', 0777, true);
            }
            
            $writer->save($filepath);
            
            // Return the file URL
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Template Excel berhasil dibuat',
                'file_url' => base_url('admin/penugasan/download-template/' . $filename)
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function downloadTemplate($filename = null)
    {
        if (!$filename) {
            return redirect()->to('admin/penugasan/create-usulan')->with('error', 'Nama file tidak valid');
        }
        
        $filepath = WRITEPATH . 'uploads/temp/' . $filename;
        
        if (!file_exists($filepath)) {
            return redirect()->to('admin/penugasan/create-usulan')->with('error', 'File tidak ditemukan');
        }
        
        return $this->response->download($filepath, null)->setFileName($filename);
    }
}
