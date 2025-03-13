<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PenugasanModel;
use App\Models\PegawaiModel;
use App\Models\JadwalModel;
use App\Models\UnitkerjaModel;
use Config\Database;
use Config\PenugasanConfig;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DataException;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use DateTime;

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
    protected $db;
    protected $config;
    protected $helpers = ['status', 'form', 'url', 'auth', 'encrypt'];  // Menambahkan helper encrypt

    public function __construct()
    {
        $this->PenugasanModel = new PenugasanModel();
        $this->PegawaiModel = new PegawaiModel();
        $this->JadwalModel = new JadwalModel();
        $this->UnitkerjaModel = new UnitkerjaModel();
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
            $unit_eselon_1 = $unitKerjaModel->where('parent_id', 1)->findAll();
        } 
        else if ($role == 3) {
            // Koordinator can only view their own eselon 1 unit
            $unit_pegawai = $unitKerjaModel->where('id', $data_pegawai['unit_kerja_id'])->first();
            if ($unit_pegawai) {
                $unit_eselon_1 = $unitKerjaModel->where('id', $unit_pegawai['parent_id'])
                    ->where('parent_id', 1)
                    ->findAll();
            } else {
                $unit_eselon_1 = [];
            }
        } else {
            $unit_eselon_1 = [];
        }

        $data = [
            'unit_eselon_1' => $unit_eselon_1,
            'role' => $role,
            'title' => 'Kelola Penugasan',
            'data_pegawai' => $data_pegawai
        ];

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
            if (($roleId == 1 || $roleId == 2) && ($decrypted_id == 2 || $unit_kerja['parent_id'] == 2)) {
                $unit_eselon_2 = $unitKerjaModel->where('parent_id', $decrypted_id)->findAll();
                return view('admin/penugasan/daftar_unit', [
                    'title' => 'Daftar Unit Eselon 2',
                    'unit_eselon_2' => $unit_eselon_2,
                    'parent_unit' => $unit_kerja
                ]);
            }

            $query = $usulanModel
                ->select('usulan.*, pegawai.nama as nama_pengusul, unit_kerja.nama as nama_unit')
                ->join('pegawai', 'pegawai.id = usulan.upload_by')
                ->join('unit_kerja', 'unit_kerja.id = pegawai.unit_kerja_id');

            // Filter berdasarkan role
            if ($roleId == 1 || $roleId == 2) {
                // Admin dan Kepala Unit dapat melihat semua usulan
            } elseif ($roleId == 3) {
                // Koordinator Unit
                $pegawaiUnitKerja = $unitKerjaModel->find($pegawai['unit_kerja_id']);
                if ($pegawaiUnitKerja && $pegawaiUnitKerja['parent_id'] == 2) {
                    // Jika koordinator berada di unit kerja dengan parent_id = 2
                    // Hanya bisa melihat usulan dari unitnya sendiri
                    $query->where('unit_kerja.id', $pegawai['unit_kerja_id']);
                } else {
                    // Koordinator unit lain hanya melihat usulan dari unitnya
                    $query->where('unit_kerja.id', $pegawai['unit_kerja_id']);
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
            return redirect()->to('admin/penugasan')->with('error', 'Terjadi kesalahan saat memproses data');
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
            ->select('usulan.*, pegawai.nama as nama_pengusul, unit_kerja.nama as nama_unit')
            ->join('pegawai', 'pegawai.id = usulan.upload_by')
            ->join('unit_kerja', 'unit_kerja.id = pegawai.unit_kerja_id')
            ->where('pegawai.unit_kerja_id', $unit_kerja_id);

        $usulan = $query->findAll();

        return view('admin/penugasan/daftar_usulan', [
            'title' => 'Daftar Usulan Unit ' . $unit_kerja['nama'],
            'usulan' => $usulan,
            'unit_kerja' => $unit_kerja,
            'role_id' => $roleId,
            'pegawai_id' => $sessionPegawaiId
        ]);
    }

    public function daftar_usulan($id)
    {
        try {
            // Decrypt the ID
            $decrypted_id = decrypt_url($id);
            
            $penugasanModel = new PenugasanModel();
            $pegawaiModel = new PegawaiModel();
            $unitkerjaModel = new UnitkerjaModel();

            $unit_kerja = $unitkerjaModel->find($decrypted_id);
            if (!$unit_kerja) {
                return redirect()->to('admin/penugasan')->with('error', 'Unit kerja tidak ditemukan');
            }

            $data = [
                'title' => 'Daftar Usulan Jadwal Kerja - ' . $unit_kerja['nama_unit_kerja'],
                'unit_kerja' => $unit_kerja,
                'role_id' => session('role_id'),
                'usulan_list' => $penugasanModel->getUsulanByUnit($decrypted_id)
            ];

            return view('admin/penugasan/daftar_usulan', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error in daftar_usulan: ' . $e->getMessage());
            return redirect()->to('admin/penugasan')->with('error', 'Terjadi kesalahan saat memproses data');
        }
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
            $uploaderData = $pegawaiModel->select('pegawai.*, unit_kerja.parent_id')
                ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id')
                ->where('pegawai.id', $usulanData['upload_by'])
                ->first();

            // Get pegawai list based on uploader's unit
            if ($uploaderData['parent_id'] == 2) {
                // If parent_id is 2, only get pegawai from the same unit
                $data_pegawai_unit = $pegawaiModel->select('pegawai.*, unit_kerja.nama_unit_kerja')
                    ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id')
                    ->where('pegawai.unit_kerja_id', $uploaderData['unit_kerja_id'])
                    ->orderBy('pegawai.nama', 'ASC')
                    ->findAll();
            } else {
                // For other units, get pegawai with same parent_id
                $data_pegawai_unit = $pegawaiModel->select('pegawai.*, unit_kerja.nama_unit_kerja')
                    ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id')
                    ->where('unit_kerja.parent_id', $uploaderData['parent_id'])
                    ->orderBy('pegawai.nama', 'ASC')
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
            case 'WFO':
                return 'bg-primary';
            case 'WFA':
                return 'bg-success';
            default:
                return 'bg-info';
        }
    }

    public function getJadwalTersedia($usulan_id)
    {
        try {
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

        return view('admin/penugasan/create', $data);
    }

    public function storeUsulan()
    {
        try {
            $jadwalModel = new JadwalModel();
            $usulanModel = new PenugasanModel();
            $pegawaiModel = new PegawaiModel();
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
            $existingUsulan = $usulanModel->where('upload_by', $sessionPegawaiId)
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
                if (empty(array_filter($row))) continue;

                $nip = trim((string)$row[1]);
                $tanggal = trim((string)$row[2]);
                $jenis_alokasi = strtoupper(trim((string)$row[3]));
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
                $dayOfWeek = (int)$date->format('N');
                if ($dayOfWeek >= 6) { // 6 = Sabtu, 7 = Minggu
                    continue; // Lewati data weekend tanpa menambahkan error
                }

                // Validasi bulan kerja sama dengan bulan pengajuan
                if ($date->format('m') !== $bulanPengajuan) {
                    $errors[] = "Baris {$baris}: Tanggal kerja harus sesuai bulan pengajuan";
                    continue;
                }

                // Validasi jenis alokasi
                if (!in_array($jenis_alokasi, ['WFO', 'WFA'])) {
                    $errors[] = "Baris {$baris}: Jenis alokasi tidak valid (harus WFO, WFA)";
                    continue;
                }

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
                    'message' => implode("<br>", $errors)
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
                    'redirect' => base_url("admin/penugasan/editjadwal/" . encrypt_url((string)$usulanId))
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
        $existingUsulan = $usulanModel->where('upload_by', $sessionPegawaiId)
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
                continue; // Lewati jika data tidak lengkap
            }

            $existingJadwal = $jadwalModel->where('pegawai_id', $jadwal['pegawai_id'])
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

        return $this->response->setJSON(['status' => 'success', 'message' => 'Jadwal berhasil disimpan.', 'redirect' => base_url('admin/penugasan')]);
    }

    public function ajukanUsulan()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request method']);
        }

        $usulan_id = $this->request->getPost('usulan_id');

        if (!$usulan_id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter tidak valid']);
        }

        // Validasi periode pengajuan
        if (!$this->isWithinSubmissionPeriod()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => sprintf(
                    'Pengajuan hanya dapat dilakukan dari tanggal %d hingga %d. Jika tanggal %d jatuh pada hari Sabtu atau Minggu, pengajuan dapat dilakukan hingga hari Senin berikutnya.',
                    $this->config->tanggalMulaiPengajuan,
                    $this->config->tanggalAkhirPengajuan,
                    $this->config->tanggalAkhirPengajuan
                )
            ]);
        }

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
            $result = $this->JadwalModel->where('usulan_id', $usulan_id)
                ->set([
                    'status_approval' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ])
                ->update();

            if ($result === false) {
                throw new \Exception('Gagal mengupdate status jadwal');
            }

            if ($db->transStatus() === false) {
                throw new \Exception('Gagal mengupdate status usulan dan jadwal');
            }

            $db->transCommit();
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Usulan berhasil diajukan',
                'redirect' => base_url('admin/penugasan')
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
        $usulan = $usulanModel->where('upload_by', $sessionPegawaiId)
            ->where('status_approval', 1) // Cari usulan yang sedang diajukan
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
                'redirect' => base_url('admin/penugasan')
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

        $usulan_id = $this->request->getPost('usulan_id');
        $status = $this->request->getPost('status');

        if (!$usulan_id || !in_array($status, [2, 3, 4])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter tidak valid']);
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Update status in usulan table
            $this->PenugasanModel->update($usulan_id, [
                'status_approval' => $status
            ]);

            // Update status in jadwal table for all related entries
            $this->JadwalModel->where('usulan_id', $usulan_id)
                ->set(['status_approval' => $status])
                ->update();

            if ($db->transStatus() === false) {
                throw new \Exception('Gagal mengupdate status');
            }

            $db->transCommit();
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Status berhasil diupdate',
                'redirect' => base_url('admin/penugasan')
            ]);
        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function validateExcel()
    {
        try {
            $jadwalModel = new JadwalModel();
            $pegawaiModel = new PegawaiModel();
            $unitKerjaModel = new UnitKerjaModel();
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

            // Baca file Excel
            $reader = new Xlsx();
            $spreadsheet = $reader->load($fileExcel->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            array_shift($rows); // Skip header

            $errors = [];
            $uniqueNips = [];
            $dataExcel = [];

            foreach ($rows as $key => $row) {
                // Skip jika semua kolom kosong
                if (empty(array_filter($row))) continue;

                // Pastikan array memiliki minimal 4 elemen
                if (count($row) < 4) continue;

                // Ambil dan validasi data dari Excel
                $nip = trim((string)$row[1]);
                $tanggalKerja = trim((string)$row[2]);
                $jenisAlokasi = strtoupper(trim((string)$row[3]));
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

                // Skip hari weekend tanpa error
                $dayOfWeek = (int)$date->format('N');
                if ($dayOfWeek >= 6) { // 6 = Sabtu, 7 = Minggu
                    continue; // Lewati data weekend tanpa menambahkan error
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

                // Validasi unit kerja pegawai
                if ($unitKerja['parent_id'] == 2) {
                    // Untuk eselon 1, pegawai harus dari unit kerja yang sama persis
                    if ($pegawai['unit_kerja_id'] != $unitKerjaPengusul) {
                        $errors[] = "Baris {$baris}: NIP {$nip} ({$pegawai['nama']}) bukan dari unit kerja yang sama";
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
                if (!in_array($jenisAlokasi, ['WFO', 'WFA'])) {
                    $errors[] = "Baris {$baris}: Jenis alokasi harus WFO atau WFA";
                    continue;
                }

                // Validasi duplikasi NIP dan tanggal
                $nipTanggalKey = $nip . '_' . $tanggalKerja;
                if (isset($nipTanggalCombinations[$nipTanggalKey])) {
                    $errors[] = "Baris {$baris}: NIP {$nip} sudah memiliki jadwal {$nipTanggalCombinations[$nipTanggalKey]} pada tanggal {$tanggalKerja}";
                    continue;
                }
                $nipTanggalCombinations[$nipTanggalKey] = $jenisAlokasi;

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
                $errorMsg = "Pegawai berikut belum terdapat dalam Excel:<br>- ";
                $errorMsg .= implode("<br>- ", $missingPegawai);
                $errors[] = $errorMsg;
            }

            log_message('debug', 'Validation errors: ' . json_encode($errors));
            if (!empty($errors)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => implode("<br>", $errors)
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
                foreach ($uniqueNips as $nip) {
                    $pegawai = $pegawaiModel->where('nip', $nip)->first();
                    $jadwalTerdaftar = $jadwalPegawai[$nip];
                    $hariKurang = array_diff($workingDays, $jadwalTerdaftar);
                    
                    if (!empty($hariKurang)) {
                        $tanggalKurang = implode(', ', $hariKurang);
                        $errors[] = "NIP {$nip} ({$pegawai['nama']}) belum memiliki jadwal untuk tanggal: {$tanggalKurang}";
                    }
                }
            }

            if (!empty($errors)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => implode("<br>", $errors)
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'File Excel valid',
                'redirect' => base_url('admin/penugasan')
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    private function getWorkingDaysInMonth($year, $month) {
        $workingDays = [];
        $date = new DateTime("$year-$month-01");
        $lastDay = $date->format('t');

        for ($day = 1; $day <= $lastDay; $day++) {
            $date->setDate($year, $month, $day);
            $dayOfWeek = (int)$date->format('N');
            if ($dayOfWeek < 6) { // Only Monday (1) through Friday (5)
                $workingDays[] = $date->format('Y-m-d');
            }
        }
        
        return $workingDays;
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
            $data_pegawai = $this->db->table('jadwal')
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
                    if ($dayOfWeek < 6) { // Monday = 1, Friday = 5
                        $workdays[] = $current->format('Y-m-d');
                    }
                    $current->modify('+1 day');
                }
                
                // Get scheduled dates for this employee
                $scheduled_dates = $this->db->table('jadwal')
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

    public function simpanCatatanPenolakan()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $usulan_id = $this->request->getPost('usulan_id');
        $catatan = $this->request->getPost('catatan');

        if (!$usulan_id || !$catatan) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter tidak lengkap']);
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Insert catatan
            $catatanModel = new \App\Models\CatatanModel();
            $dataCatatan = [
                'usulan_id' => $usulan_id,
                'catatan' => $catatan
            ];
            
            $catatan_id = $catatanModel->insert($dataCatatan);

            if (!$catatan_id) {
                throw new \Exception('Gagal menyimpan catatan');
            }

            // Update status usulan menjadi ditolak (3) dan update catatan_id
            $usulanModel = new \App\Models\PenugasanModel();
            $dataUsulan = [
                'status_approval' => 3,
                'catatan_id' => $catatan_id
            ];

            if (!$usulanModel->update($usulan_id, $dataUsulan)) {
                throw new \Exception('Gagal mengupdate status usulan');
            }

            $db->transCommit();
            return $this->response->setJSON(['status' => 'success', 'message' => 'Usulan berhasil ditolak', 'redirect' => base_url('admin/penugasan')]);

        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function isWithinSubmissionPeriod()
    {
        $tanggalSekarang = (int)date('d');
        $hariSekarang = (int)date('N'); // 1 (Senin) sampai 7 (Minggu)
        
        // Jika tanggal sekarang dalam rentang normal
        if ($tanggalSekarang >= $this->config->tanggalMulaiPengajuan && 
            $tanggalSekarang <= $this->config->tanggalAkhirPengajuan) {
            return true;
        }
        
        // Jika melewati tanggal akhir tapi masih dalam batas perpanjangan
        if ($tanggalSekarang > $this->config->tanggalAkhirPengajuan) {
            // Jika dalam batas perpanjangan
            $selisihHari = $tanggalSekarang - $this->config->tanggalAkhirPengajuan;
            if ($selisihHari <= $this->config->batasPerpanjangan) {
                // Jika hari ini Senin atau tanggal akhir jatuh di weekend
                if ($hariSekarang == 1 || // Hari ini Senin
                    $this->isWeekend($this->config->tanggalAkhirPengajuan)) {
                    return true;
                }
            }
        }
        
        return false;
    }
    
    private function isWeekend($day) 
    {
        $date = new \DateTime();
        $date->setDate($date->format('Y'), $date->format('m'), $day);
        $dayOfWeek = (int)$date->format('N');
        return ($dayOfWeek == 6 || $dayOfWeek == 7); // 6 = Sabtu, 7 = Minggu
    }
}
