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
    protected $helpers = ['status', 'form', 'url'];

    public function __construct()
    {
        $this->PenugasanModel = new PenugasanModel();
        $this->PegawaiModel = new PegawaiModel();
        $this->JadwalModel = new JadwalModel();
        $this->UnitkerjaModel = new UnitKerjaModel();
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
                $unit_eselon_1 = $unitKerjaModel
                    ->where('id', $unit_pegawai['parent_id'])
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
        $usulanModel = new PenugasanModel();
        $pegawaiModel = new PegawaiModel();
        $unitKerjaModel = new UnitKerjaModel();

        $sessionPegawaiId = session('pegawai_id');
        $roleId = session('role_id');

        if (!$sessionPegawaiId) {
            return redirect()->to(base_url('auth'));
        }

        // Get unit kerja data
        $unit_kerja = $unitKerjaModel->find($id);
        if (!$unit_kerja) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unit kerja tidak ditemukan'
            ]);
        }

        if ($roleId == 1 || $roleId == 2) {
            $data = [
                'id' => $unit_kerja['id'],
                'nama' => $unit_kerja['nama_unit_kerja'],
                'parent_id' => $unit_kerja['parent_id']
            ];
        } else {
            $data = [
                'id' => $unit_kerja['id'],
                'nama' => $unit_kerja['nama_unit_kerja'],
                'parent_id' => $unit_kerja['parent_id']
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function daftar_usulan($id)
    {
        $usulanModel = new PenugasanModel();
        $pegawaiModel = new PegawaiModel();
        $unitKerjaModel = new UnitKerjaModel();

        $sessionPegawaiId = session('pegawai_id');
        $roleId = session('role_id');

        if (!$sessionPegawaiId) {
            return redirect()->to(base_url('auth'));
        }

        // Get pegawai beserta unit kerjanya
        $pegawai = $pegawaiModel->find($sessionPegawaiId);
        if (!$pegawai) {
            return redirect()->back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        // Get unit kerja yang sedang dilihat
        $unit_kerja = $unitKerjaModel->find($id);
        if (!$unit_kerja) {
            return redirect()->back()->with('error', 'Unit kerja tidak ditemukan.');
        }

        $query = $usulanModel
            ->select('usulan.*, pegawai.nama as nama_pengusul, unit_kerja.nama_unit_kerja as nama_unit')
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
    }

    public function EditJadwal($id)
    {
        $penugasanModel = new PenugasanModel();
        $pegawaiModel = new PegawaiModel();
        $usulanData = $penugasanModel->find($id);

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
            'usulan_id' => $id
        ];

        return view('admin/penugasan/editjadwal', $data);
    }

    private function getEventClass($jenis_alokasi)
    {
        switch ($jenis_alokasi) {
            case 'WFO':
                return 'bg-primary';
            case 'WFH':
                return 'bg-success';
            case 'DINAS':
                return 'bg-warning';
            default:
                return 'bg-info';
        }
    }

    public function getJadwalTersedia($pegawaiId)
    {
        $jadwalModel = new JadwalModel();

        log_message('debug', "📡 Request masuk untuk pegawai ID: {$pegawaiId}");

        $jadwal = $jadwalModel->where('pegawai_id', $pegawaiId)->findAll();

        if (!$jadwal) {
            log_message('warning', "⚠ Tidak ditemukan jadwal untuk pegawai ID: {$pegawaiId}");
        } else {
            log_message('debug', "✅ Ditemukan " . count($jadwal) . " jadwal untuk pegawai ID: {$pegawaiId}");
        }

        $tanggalTerisi = [];
        foreach ($jadwal as $row) {
            $tanggalTerisi[$row['tanggal_kerja']] = $row['jenis_alokasi'];
        }

        log_message('debug', "📤 Response Data: " . json_encode($tanggalTerisi));

        return $this->response->setJSON([
            'status' => 'success',
            'tanggal_terisi' => $tanggalTerisi
        ]);
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

            // Validasi tanggal pengajuan dinonaktifkan
            // if (!$this->isWithinSubmissionPeriod()) {
            //     return $this->response->setJSON([
            //         'status' => 'error',
            //         'message' => sprintf(
            //             'Pengajuan hanya dapat dilakukan dari tanggal %d hingga %d. Jika tanggal %d jatuh pada hari Sabtu atau Minggu, pengajuan dapat dilakukan hingga hari Senin berikutnya.',
            //             $this->config->tanggalMulaiPengajuan,
            //             $this->config->tanggalAkhirPengajuan,
            //             $this->config->tanggalAkhirPengajuan
            //         )
            //     ]);
            // }

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
            $nipTanggalCombinations = []; 
            $bulanTanggalKerja = null;

            $namaBulanIndonesia = [
                '01' => 'Januari',
                '02' => 'Februari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember'
            ];

            // Ambil unit kerja pengusul
            $pengusul = $pegawaiModel->find($sessionPegawaiId);
            if (!$pengusul) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data pengusul tidak ditemukan.']);
            }
            $unitKerjaPengusul = $pengusul['unit_kerja_id'];

            // Validasi data Excel
            foreach ($rows as $key => $row) {
                if ($key == 0) continue; // Skip header

                $nip = isset($row[1]) ? trim((string)$row[1]) : ''; // Kolom B (nip_pegawai)
                $tanggalKerja = isset($row[2]) ? trim((string)$row[2]) : ''; // Kolom C (tanggal_kerja)
                $jenisAlokasi = isset($row[3]) ? strtoupper(trim((string)$row[3])) : ''; // Kolom D (jenis_alokasi)

                // Skip jika semua kolom kosong
                if (empty($nip) || empty($tanggalKerja) || empty($jenisAlokasi)) {
                    continue;
                }

                // Skip header row
                if ($nip === 'nip_pegawai' || $tanggalKerja === 'tanggal_kerja') {
                    continue;
                }

                // Validasi format tanggal
                if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggalKerja)) {
                    $errors[] = "Baris " . ($key + 1) . ": Format tanggal tidak valid (harus YYYY-mm-dd)";
                    continue;
                }

                // Ambil bulan dari tanggal pertama jika belum diset
                if ($bulanTanggalKerja === null) {
                    $bulanTanggalKerja = date('m', strtotime($tanggalKerja));
                }

                // Cek apakah semua tanggal berada di bulan yang sama
                $currentBulan = date('m', strtotime($tanggalKerja));
                if ($currentBulan !== $bulanTanggalKerja) {
                    $errors[] = sprintf(
                        "Error: File Excel berisi jadwal untuk bulan yang berbeda. Tanggal %s pada baris %d tidak sesuai dengan bulan jadwal lainnya.",
                        $tanggalKerja,
                        $key + 1
                    );
                    break;
                }

                if ($currentBulan !== $bulanPengajuan) {
                    $namaBulanExcel = $namaBulanIndonesia[$currentBulan];
                    $namaBulanPengajuan = $namaBulanIndonesia[$bulanPengajuan];
                    $errors[] = sprintf(
                        "Error: Bulan jadwal kerja (%s) tidak sesuai dengan bulan pengajuan (%s)",
                        $namaBulanExcel,
                        $namaBulanPengajuan
                    );
                    break;
                }

                if (!preg_match('/^[0-9]{18}$/', $nip)) {
                    $errors[] = "Baris " . ($key + 1) . ": Format NIP tidak valid (harus 18 digit angka)";
                    continue;
                }

                $pegawai = $pegawaiModel->where('nip', $nip)->first();
                if (!$pegawai) {
                    $errors[] = "Baris " . ($key + 1) . ": NIP $nip tidak terdaftar dalam database";
                    continue;
                }

                if ($pegawai['unit_kerja_id'] !== $unitKerjaPengusul) {
                    $errors[] = sprintf(
                        "Baris %d: NIP %s tidak berada dalam unit kerja yang sama dengan pengusul",
                        $key + 1,
                        $nip
                    );
                    continue;
                }

                // Cek apakah NIP sudah ada jadwalnya di bulan yang sama
                $existingJadwal = $jadwalModel
                    ->join('usulan', 'usulan.id = jadwal.usulan_id')
                    ->where('jadwal.pegawai_id', $pegawai['id'])
                    ->where('usulan.bulan', $bulanTahun)
                    ->where('usulan.status_approval !=', -1) // Tidak termasuk yang dibatalkan
                    ->first();

                if ($existingJadwal) {
                    $errors[] = sprintf(
                        "Baris %d: NIP %s sudah memiliki jadwal pada bulan %s %s",
                        $key + 1,
                        $nip,
                        $namaBulanIndonesia[$bulanPengajuan],
                        $tahunPengajuan
                    );
                    continue;
                }

                // Validasi jenis alokasi
                if (!in_array($jenisAlokasi, ['WFA', 'WFO'])) {
                    $errors[] = "Baris " . ($key + 1) . ": Jenis alokasi harus WFA atau WFO";
                    continue;
                }

                // Cek kombinasi NIP dan tanggal yang sama
                $nipTanggalKey = $nip . '_' . $tanggalKerja;
                if (isset($nipTanggalCombinations[$nipTanggalKey])) {
                    $errors[] = sprintf(
                        "Baris %d: NIP %s sudah memiliki jadwal pada tanggal %s",
                        $key + 1,
                        $nip,
                        $tanggalKerja
                    );
                    continue;
                }
                $nipTanggalCombinations[$nipTanggalKey] = true;

                // Cek apakah hari Sabtu atau Minggu
                $dayOfWeek = date('w', strtotime($tanggalKerja));
                if ($dayOfWeek == 0 || $dayOfWeek == 6) {
                    continue; // Skip untuk hari Sabtu (6) dan Minggu (0)
                }

                // Simpan data valid untuk diinsert
                $insertData[] = [
                    'pegawai_id' => $pegawai['id'],
                    'tanggal_kerja' => $tanggalKerja,
                    'jenis_alokasi' => $jenisAlokasi
                ];
            }

            // Jika ada error dalam Excel, return error
            if (!empty($errors)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => "Terdapat kesalahan dalam file Excel:\n" . implode("\n", $errors)
                ]);
            }

            // Jika tidak ada data valid untuk diinsert
            if (empty($insertData)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Tidak ada data valid untuk disimpan dalam file Excel.'
                ]);
            }

            // ** Jika semua validasi sukses, simpan file surat **
            $fileName = $fileSurat->getRandomName();
            $fileSurat->move(ROOTPATH . 'public/uploads/data_dukung', $fileName);

            // ** Insert ke tabel Usulan **
            $usulanData = [
                'bulan' => $bulanTahun,
                'upload_by' => $sessionPegawaiId,
                'file_surat' => $fileName,
                'status_approval' => 0,
            ];

            $db = \Config\Database::connect();
            $db->transStart();

            try {
                // Insert usulan
                $usulanId = $usulanModel->insert($usulanData, true);

                // Update usulan_id di data jadwal
                foreach ($insertData as &$data) {
                    $data['usulan_id'] = $usulanId;
                }

                // Insert batch jadwal
                $jadwalModel->insertBatch($insertData);

                $db->transComplete();

                if ($db->transStatus() === false) {
                    // Jika transaksi gagal, hapus file yang sudah diupload
                    unlink(ROOTPATH . 'public/uploads/data_dukung/' . $fileName);
                    throw new \Exception('Gagal menyimpan data ke database.');
                }

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Jadwal berhasil disimpan.',
                    'redirect' => base_url("admin/penugasan/editjadwal/$usulanId")
                ]);
            } catch (\Exception $e) {
                $db->transRollback();
                // Hapus file yang sudah diupload jika ada error
                if (file_exists(ROOTPATH . 'public/uploads/data_dukung/' . $fileName)) {
                    unlink(ROOTPATH . 'public/uploads/data_dukung/' . $fileName);
                }
                return $this->response->setJSON(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
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

        return $this->response->setJSON(['status' => 'success', 'message' => 'Jadwal berhasil disimpan.']);
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
                'message' => 'Usulan berhasil diajukan'
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
                'usulan_id' => $usulan['id']
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
                'message' => 'Status berhasil diupdate'
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
                throw new \Exception('Session pegawai tidak ditemukan.');
            }

            // Ambil data pegawai dan unit kerjanya
            $pegawai = $pegawaiModel->where('id', $sessionPegawaiId)->first();
            if (!$pegawai) {
                throw new \Exception('Data pegawai tidak ditemukan.');
            }

            $unitKerjaPengusul = $pegawai['unit_kerja_id'];
            
            // Ambil data unit kerja pengusul
            $unitKerja = $unitKerjaModel
                ->select('unit_kerja.*, parent.id as parent_id, parent.nama_unit_kerja as parent_nama')
                ->join('unit_kerja as parent', 'unit_kerja.parent_id = parent.id', 'left')
                ->find($unitKerjaPengusul);

            if (!$unitKerja) {
                throw new \Exception('Unit kerja pengusul tidak ditemukan.');
            }

            // Validasi file Excel
            $fileExcel = $this->request->getFile('file_excel');
            if (!$fileExcel->isValid()) {
                throw new \Exception('File Excel tidak valid.');
            }

            // Ambil bulan pengajuan dari form
            $bulanPengajuan = $this->request->getPost('bulan');
            if (!$bulanPengajuan) {
                throw new \Exception('Bulan pengajuan harus diisi.');
            }

            // Baca file Excel
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($fileExcel->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            array_shift($rows); // Skip header

            $errors = [];
            $uniqueNips = [];
            $nipTanggalCombinations = []; // Track NIP and date combinations
            $alokasiPerTanggal = [];
            $jadwalPerPegawai = []; // Track jumlah hari kerja per pegawai
            $alokasiPerTanggalNIP = []; // Track alokasi per tanggal per NIP

            // Get holidays from database or API
            $holidays = $this->getHolidays($bulanPengajuan);

            foreach ($rows as $key => $row) {
                // Skip jika semua kolom kosong
                if (empty(array_filter($row))) continue;

                // Pastikan array memiliki minimal 4 elemen
                if (count($row) < 4) continue;

                // Ambil dan validasi data dari Excel
                $nip = isset($row[1]) ? trim((string)$row[1]) : ''; // Kolom B (nip_pegawai)
                $tanggalKerja = isset($row[2]) ? trim((string)$row[2]) : ''; // Kolom C (tanggal_kerja)
                $jenisAlokasi = isset($row[3]) ? strtoupper(trim((string)$row[3])) : ''; // Kolom D (jenis_alokasi)

                // Skip jika baris kosong
                if (empty($nip) || empty($tanggalKerja) || empty($jenisAlokasi)) {
                    continue;
                }

                // Skip header row
                if ($nip === 'nip_pegawai' || $tanggalKerja === 'tanggal_kerja') {
                    continue;
                }

                // Validasi format tanggal
                $date = DateTime::createFromFormat('Y-m-d', $tanggalKerja);
                if (!$date || $date->format('Y-m-d') !== $tanggalKerja) {
                    $errors[] = "Baris " . ($key + 2) . ": Format tanggal tidak valid (gunakan format YYYY-MM-DD)";
                    continue;
                }

                // Skip validasi untuk hari Sabtu dan Minggu
                $dayOfWeek = $date->format('N'); // 1 (Senin) sampai 7 (Minggu)
                if ($dayOfWeek >= 6) {
                    $errors[] = "Baris " . ($key + 2) . ": Tanggal $tanggalKerja adalah hari Sabtu/Minggu";
                    continue;
                }

                // Skip validasi untuk hari libur
                if (in_array($tanggalKerja, $holidays)) {
                    $errors[] = "Baris " . ($key + 2) . ": Tanggal $tanggalKerja adalah hari libur";
                    continue;
                }

                // Validasi WFA tidak boleh di hari Senin
                if ($dayOfWeek == 1 && $jenisAlokasi == 'WFA') {
                    $errors[] = "Baris " . ($key + 2) . ": Tidak boleh WFA di hari Senin";
                    continue;
                }

                // Validasi NIP (18 digit angka)
                if (!preg_match('/^[0-9]{18}$/', $nip)) {
                    $errors[] = "Baris " . ($key + 2) . ": Format NIP tidak valid (harus 18 digit angka)";
                    continue;
                }

                // Validasi NIP ada di database dan sesuai unit kerja
                $pegawaiData = $pegawaiModel->where('nip', $nip)->first();
                if (!$pegawaiData) {
                    $errors[] = "Baris " . ($key + 2) . ": NIP $nip tidak terdaftar dalam database";
                    continue;
                }

                // Khusus untuk Sekretariat (parent_id = 2), validasi hanya di level biro
                if ($unitKerja['parent_id'] == 2) {
                    if ($pegawaiData['unit_kerja_id'] != $unitKerjaPengusul) {
                        $errors[] = "Baris " . ($key + 2) . ": NIP $nip tidak termasuk dalam unit kerja Anda";
                        continue;
                    }
                } else {
                    // Untuk unit kerja lain, cek berdasarkan parent_id
                    $pegawaiUnitKerja = $unitKerjaModel->find($pegawaiData['unit_kerja_id']);
                    if ($pegawaiUnitKerja['parent_id'] != $unitKerja['parent_id']) {
                        $errors[] = "Baris " . ($key + 2) . ": NIP $nip tidak termasuk dalam unit kerja Anda";
                        continue;
                    }
                }

                // Validasi bulan kerja sama dengan bulan pengajuan
                if ($date->format('m') !== $bulanPengajuan) {
                    $errors[] = "Baris " . ($key + 2) . ": Tanggal kerja harus di bulan yang sama dengan bulan pengajuan";
                    continue;
                }

                // Cek duplikasi alokasi pada tanggal yang sama
                $tanggalKey = $tanggalKerja;
                if (isset($alokasiPerTanggalNIP[$tanggalKey][$nip])) {
                    $errors[] = "Baris " . ($key + 2) . ": NIP $nip sudah memiliki alokasi pada tanggal $tanggalKerja";
                    continue;
                }
                $alokasiPerTanggalNIP[$tanggalKey][$nip] = $jenisAlokasi;

                // Track jadwal per pegawai untuk cek kelengkapan
                if (!isset($jadwalPerPegawai[$nip])) {
                    $jadwalPerPegawai[$nip] = [];
                }
                $jadwalPerPegawai[$nip][] = $tanggalKerja;

                // Cek jadwal yang sudah ada di database
                $existingJadwal = $jadwalModel
                    ->join('usulan', 'usulan.id = jadwal.usulan_id')
                    ->join('pegawai', 'pegawai.id = jadwal.pegawai_id')
                    ->where('pegawai.nip', $nip)
                    ->where('jadwal.tanggal_kerja', $tanggalKerja)
                    ->where('usulan.status_approval !=', 3) // Tidak termasuk yang ditolak
                    ->first();

                if ($existingJadwal) {
                    $errors[] = "Baris " . ($key + 2) . ": NIP $nip sudah memiliki jadwal pada tanggal $tanggalKerja";
                    continue;
                }

                if (!in_array($nip, $uniqueNips)) {
                    $uniqueNips[] = $nip;
                }
            }

            // Validasi kelengkapan jadwal sebulan untuk setiap pegawai
            $workingDaysInMonth = $this->getWorkingDaysInMonth($bulanPengajuan, $holidays);
            foreach ($jadwalPerPegawai as $nip => $dates) {
                $uniqueDates = array_unique($dates);
                if (count($uniqueDates) < $workingDaysInMonth) {
                    $errors[] = "NIP $nip: Jadwal tidak lengkap, hanya mengisi " . count($uniqueDates) . " dari $workingDaysInMonth hari kerja";
                }
            }

            // Cek pegawai yang belum ada di Excel
            if ($unitKerja['parent_id'] == 2) {
                // Untuk Sekretariat, ambil pegawai di level biro saja
                $allPegawai = $pegawaiModel
                    ->where('unit_kerja_id', $unitKerjaPengusul)
                    ->findAll();
            } else {
                // Untuk unit lain, ambil semua pegawai dengan parent_id yang sama
                $allPegawai = $pegawaiModel
                    ->select('pegawai.*, unit_kerja.parent_id')
                    ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id')
                    ->where('unit_kerja.parent_id', $unitKerja['parent_id'])
                    ->findAll();
            }

            $missingPegawai = [];
            foreach ($allPegawai as $p) {
                if (!in_array($p['nip'], $uniqueNips)) {
                    $missingPegawai[] = $p['nip'];
                }
            }

            if (!empty($missingPegawai)) {
                $errors[] = "Pegawai dengan NIP berikut tidak memiliki jadwal: " . implode(", ", $missingPegawai);
            }

            if (!empty($errors)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Terdapat kesalahan dalam file Excel',
                    'errors' => implode("<br>", array_map(function($error) {
                        return trim($error);
                    }, $errors))
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'File Excel valid, silakan klik tombol Simpan untuk melanjutkan'
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem',
                'errors' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    private function getWorkingDaysInMonth($month, $holidays) {
        $year = date('Y');
        $date = new DateTime("$year-$month-01");
        $daysInMonth = $date->format('t');
        
        $workingDays = 0;
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDate = new DateTime("$year-$month-$day");
            $dayOfWeek = $currentDate->format('N'); // 1 (Senin) sampai 7 (Minggu)
            $dateString = $currentDate->format('Y-m-d');
            
            // Skip weekends and holidays
            if ($dayOfWeek < 6 && !in_array($dateString, $holidays)) {
                $workingDays++;
            }
        }
        
        return $workingDays;
    }

    private function getHolidays($month) {
        // TODO: Implement holiday fetching from database or API
        // For now, return empty array
        return [];
    }
}
