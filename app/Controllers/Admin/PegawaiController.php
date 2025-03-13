<?php

namespace App\Controllers\Admin;

use App\Models\PegawaiModel;
use App\Models\JabatanModel;
use App\Models\UnitKerjaModel; // Pastikan model unit kerja digunakan
use App\Models\StatuspegawaiModel;
use App\Models\StatuspernikahanModel;
use App\Models\JenjangpangkatModel;
use App\Models\AgamaModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Dompdf\Dompdf;
use Dompdf\Options;

class PegawaiController extends Controller
{
    protected $pegawaiModel;
    protected $jabatanModel;
    protected $statuspegawaiModel;
    protected $statuspernikahanModel;
    protected $jenjangpangkatModel;
    protected $agamaModel;
    protected $userModel;

    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
        $this->jabatanModel = new JabatanModel();
        $this->statuspegawaiModel = new StatuspegawaiModel();
        $this->statuspernikahanModel = new StatuspernikahanModel();
        $this->jenjangpangkatModel = new JenjangpangkatModel();
        $this->agamaModel = new AgamaModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $PegawaiModel = new PegawaiModel();
        $search = $this->request->getGet('search');
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        // Get all pegawai data
        if ($search) {
            $pegawai = $this->pegawaiModel->searchPegawai($search);
        } else {
            $pegawai = $this->pegawaiModel->getAllPegawai();
        }

        $data = [
            'pegawai' => $pegawai,
            'pager' => $PegawaiModel->pager,
            'currentPage' => $currentPage,
            'search' => $search,
        ];


        // dd($data);
        return view('admin/pegawai/index', $data);
    }

    /**
     * Get detailed employee data for modal view
     */
    public function viewDetail($id)
    {
        $pegawaiModel = new \App\Models\PegawaiModel();
        $pegawai = $pegawaiModel->getDetailedPegawai($id);

        if (!$pegawai) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data pegawai tidak ditemukan'
            ]);
        }

        // Format tanggal lahir
        if (!empty($pegawai['tanggal_lahir'])) {
            $pegawai['tanggal_lahir_formatted'] = date('d-m-Y', strtotime($pegawai['tanggal_lahir']));
        } else {
            $pegawai['tanggal_lahir_formatted'] = '-';
        }

        // Format TMT
        if (!empty($pegawai['tmt'])) {
            $pegawai['tmt_formatted'] = date('d-m-Y', strtotime($pegawai['tmt']));
        } else {
            $pegawai['tmt_formatted'] = '-';
        }

        // Render the view
        $html = view('admin/pegawai/detail_modal', ['pegawai' => $pegawai]);

        return $this->response->setJSON([
            'status' => 'success',
            'html' => $html
        ]);
    }

    public function check_nip()
    {
        $nip = $this->request->getPost('nip');
        $exists = $this->pegawaiModel->where('nip', $nip)->first();

        if ($exists) {
            return $this->response->setJSON(['status' => 'error_pegawai', 'message' => 'NIP sudah terdaftar']);
        } else {
            return $this->response->setJSON(['status' => 'success_pegawai']);
        }
    }

    public function create()
    {

        $statuspegawaiModel = new StatuspegawaiModel();
        $statuspernikahanModel = new StatuspernikahanModel();
        $jenjangpangkatModel = new JenjangpangkatModel();
        $agamaModel = new AgamaModel();
        $unitKerjaModel = new UnitKerjaModel();
        $data = [
            'jabatan' => $this->jabatanModel->findAll(),
            'unit' => $unitKerjaModel->findAll(),
            'statuspegawai' => $statuspegawaiModel->findAll(),
            'statuspernikahan' => $statuspernikahanModel->findAll(),
            'jenjangpangkat' => $jenjangpangkatModel->findAll(),
            'agama' => $agamaModel->findAll()

        ];

        // dd($data);
        return view('admin/pegawai/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        // Validation rules for the form inputs
        $validation->setRules([
            'nip' => [
                'label' => 'NIP',
                'rules' => 'required|min_length[10]|is_unique[pegawai.nip]',
                'errors' => [
                    'required' => 'NIP harus diisi.',
                    'min_length' => 'NIP harus memiliki panjang minimal 10 karakter.',
                    'is_unique' => 'NIP sudah terdaftar.',
                ]
            ],
            'nama' => [
                'label' => 'Nama',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi.',
                ]
            ],
            'tempat_lahir' => [
                'label' => 'Tempat Lahir',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tempat lahir harus diisi.',
                ]
            ],
            'tanggal_lahir' => [
                'label' => 'Tanggal Lahir',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal lahir harus diisi.',
                    'valid_date' => 'Tanggal lahir tidak valid.',
                ]
            ],
            'pangkat' => [
                'label' => 'Pangkat',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pangkat harus diisi.',
                ]
            ],
            'golongan_ruang' => [
                'label' => 'Golongan Ruang',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Golongan ruang harus diisi.',
                ]
            ],
            'jabatan_id' => [
                'label' => 'Jabatan',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jabatan harus diisi.',
                ]
            ],
            'unit_kerja_id' => [
                'label' => 'Unit Kerja',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Unit kerja harus diisi.',
                ]
            ],
            'kelas_jabatan' => [
                'label' => 'Kelas Jabatan',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelas jabatan harus diisi.',
                ]
            ],
            'jenis_kelamin' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis kelamin harus dipilih.',
                ]
            ],
            'status_pegawai' => [
                'label' => 'Status Pegawai',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status pegawai harus dipilih.',
                ]
            ],
            'status_pernikahan' => [
                'label' => 'Status Pernikahan',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status pernikahan harus dipilih.',
                ]
            ],
            'foto' => [
                'label' => 'Foto',
                'rules' => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg]|max_size[foto,2048]',
                'errors' => [
                    'is_image' => 'File yang diunggah harus berupa gambar.',
                    'mime_in' => 'Format gambar yang diizinkan adalah JPG atau JPEG.',
                    'max_size' => 'Ukuran gambar maksimal 2MB.',
                ]
            ],
            'agama' => [
                'label' => 'Agama',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Agama harus dipilih.',
                ]
            ],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),
            ]);
        }

        // Handle photo upload or use default photo
        $foto = $this->request->getFile('foto');
        $fotoName = 'default.jpg';
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            try {
                $fotoName = $foto->getRandomName();
                $foto->move(WRITEPATH . '../public/img/pegawai', $fotoName);
            } catch (\Exception $e) {
                return $this->response->setStatusCode(500)->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal mengunggah foto.',
                ]);
            }
        }

        $nip = $this->request->getPost('nip');
        $pegawaiModel = new PegawaiModel();
        $existingPegawai = $pegawaiModel->where('nip', $nip)->first();

        if ($existingPegawai) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => [
                    'nip' => 'NIP sudah terdaftar.',
                ],
            ]);
        }

        // Prepare data to insert into the database
        $data = [
            'nip' => $nip,
            'gelar_depan' => $this->request->getPost('gelar_depan'),
            'nama' => $this->request->getPost('nama'),
            'gelar_belakang' => $this->request->getPost('gelar_belakang'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'pangkat' => $this->request->getPost('pangkat'),
            'golongan_ruang' => $this->request->getPost('golongan_ruang'),
            'jabatan_id' => $this->request->getPost('jabatan_id'),
            'unit_kerja_id' => $this->request->getPost('unit_kerja_id'),
            'kelas_jabatan' => $this->request->getPost('kelas_jabatan'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'status_pegawai' => $this->request->getPost('status_pegawai'),
            'status_pernikahan' => $this->request->getPost('status_pernikahan'),
            'jumlah_anak' => $this->request->getPost('jumlah_anak'),
            'foto' => $fotoName,
            'agama' => $this->request->getPost('agama'),
        ];

        $pegawaiModel->insert($data);

        // Return success response
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data pegawai berhasil disimpan.',
        ]);
    }
    public function edit($id)
    {
        $pegawaiModel = new PegawaiModel();
        $statuspegawaiModel = new StatuspegawaiModel();
        $statuspernikahanModel = new StatuspernikahanModel();
        $jenjangpangkatModel = new JenjangpangkatModel();
        $unitKerjaModel = new UnitKerjaModel();
        $agamaModel = new AgamaModel();



        $data = [
            'pegawai' => $pegawaiModel->find($id),
            'jabatan' => $this->jabatanModel->findAll(),
            'statuspegawai'=> $statuspegawaiModel->findAll(),
            'statuspernikahan' => $statuspernikahanModel->findAll(),
            'jenjangpangkat' => $jenjangpangkatModel->findAll(),
            'agama' => $agamaModel->findAll(),
            'unit_kerja' => $unitKerjaModel->findAll()
        ];
        

        return view('admin/pegawai/edit', $data);
    }


    public function update($id)
    {

        $validation = \Config\Services::validation();

        // Validation rules for the form inputs
        $validation->setRules([
            'nip' => [
                'label' => 'NIP',
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => 'NIP harus diisi.',
                    'min_length' => 'NIP harus memiliki panjang minimal 10 karakter.',
                    
                ]
            ],
            'nama' => [
                'label' => 'Nama',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi.',
                ]
            ],
            'tempat_lahir' => [
                'label' => 'Tempat Lahir',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tempat lahir harus diisi.',
                ]
            ],
            'tanggal_lahir' => [
                'label' => 'Tanggal Lahir',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal lahir harus diisi.',
                    'valid_date' => 'Tanggal lahir tidak valid.',
                ]
            ],
            'pangkat' => [
                'label' => 'Pangkat',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pangkat harus diisi.',
                ]
            ],
            'golongan_ruang' => [
                'label' => 'Golongan Ruang',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Golongan ruang harus diisi.',
                ]
            ],
            'jabatan_id' => [
                'label' => 'Jabatan',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jabatan harus diisi.',
                ]
            ],
            'unit_kerja_id' => [
                'label' => 'Unit Kerja',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Unit kerja harus diisi.',
                ]
            ],
            'kelas_jabatan' => [
                'label' => 'Kelas Jabatan',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelas jabatan harus diisi.',
                ]
            ],
            'jenis_kelamin' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis kelamin harus dipilih.',
                ]
            ],
            'status_pegawai' => [
                'label' => 'Status Pegawai',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status pegawai harus dipilih.',
                ]
            ],
            'status_pernikahan' => [
                'label' => 'Status Pernikahan',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status pernikahan harus dipilih.',
                ]
            ],
            'foto' => [
                'label' => 'Foto',
                'rules' => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg]|max_size[foto,2048]',
                'errors' => [
                    'is_image' => 'File yang diunggah harus berupa gambar.',
                    'mime_in' => 'Format gambar yang diizinkan adalah JPG atau JPEG.',
                    'max_size' => 'Ukuran gambar maksimal 2MB.',
                ]
            ],
            'agama' => [
                'label' => 'Agama',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Agama harus dipilih.',
                ]
            ],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),
            ]);
        }

        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'img', $newName);
            $data['foto'] = $newName;
        }


        $foto = $this->request->getFile('foto');
        $fotoName = 'default.jpg';
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            try {
                $fotoName = $foto->getRandomName();
                $foto->move(WRITEPATH . '../public/img/pegawai', $fotoName);
            } catch (\Exception $e) {
                return $this->response->setStatusCode(500)->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal mengunggah foto.',
                ]);
            }
        }

        $data = [
            'nip' => $this->request->getPost('nip'),
            'gelar_depan' => $this->request->getPost('gelar_depan'),
            'nama' => $this->request->getPost('nama'),
            'gelar_belakang' => $this->request->getPost('gelar_belakang'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'pangkat' => $this->request->getPost('pangkat'),
            'golongan_ruang' => $this->request->getPost('golongan_ruang'),
            'jabatan_id' => $this->request->getPost('jabatan_id'),
            'unit_kerja_id' => $this->request->getPost('unit_kerja_id'),
            'kelas_jabatan' => $this->request->getPost('kelas_jabatan'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'status_pegawai' => $this->request->getPost('status_pegawai'),
            'status_pernikahan' => $this->request->getPost('status_pernikahan'),
            'jumlah_anak' => $this->request->getPost('jumlah_anak'),
            'foto' => $fotoName,
            'agama' => $this->request->getPost('agama'),
        ];

        

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data pegawai berhasil disimpan.',
        ]);
    }

    public function delete($id)
    {
        $this->pegawaiModel->delete($id); // Soft delete, tidak menghapus data secara permanen
        return redirect()->to('/admin/pegawai')->with('message', 'Data berhasil dihapus.');
    }

    // public function uploadXlsx()
    //     {
    //         $file = $this->request->getFile('xlsx_file');

    //         if ($file->isValid() && !$file->hasMoved()) {
    //             $spreadsheet = IOFactory::load($file->getTempName());
    //             $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    //             $pegawaiModel = new PegawaiModel();
    //             $jabatanModel = new JabatanModel();
    //             $unitKerjaModel = new UnitKerjaModel();
    //             $unitKerjaaModel = new UnitKerjaaModel();

    //             foreach ($sheetData as $index => $data) {
    //                 if ($index == 1) continue; // Lewati baris header

    //                  Validasi jabatan, unit kerja, dan unit kerjaa berdasarkan nama
    //                  Validasi jabatan, unit kerja, dan unit kerjaa berdasarkan id
    //                 $jabatan = $jabatanModel->find($data['I']); 
    //                 $unitKerja = $unitKerjaModel->find($data['J']);
    //                 $unitKerjaa = $unitKerjaaModel->find($data['K']);


    //                 $pegawaiModel->insert([
    //                     'nip' => $data['A'],
    //                     'gelar_depan' => $data['B'],
    //                     'nama' => $data['C'],
    //                     'gelar_belakang' => $data['D'],
    //                     'tempat_lahir' => $data['E'],
    //                     'tanggal_lahir' => $data['F'],
    //                     'pangkat' => $data['G'],
    //                     'golongan_ruang' => $data['H'],
    //                     'jabatan_id' => $jabatan ? $jabatan['id'] : null,
    //                     'unit_kerja_id' => $unitKerja ? $unitKerja['id'] : null,
    //                     'kelas_jabatan' => $data['L'],
    //                     'jenis_kelamin' => $data['M'],
    //                     'status_pegawai' => $data['N'],
    //                     'status_pernikahan' => $data['O'],
    //                     'jumlah_anak' => $data['P'],
    //                     'agama' => $data['Q']
    //                 ]);
    //             }

    //             return redirect()->to('/pegawai/pegawai')->with('success', 'Data berhasil ditambahkan.');
    //         }

    //         return redirect()->to('/pegawai/pegawai')->with('error', 'Data gagal ditambahkan.');
    //     }

    public function uploadXlsx()
    {
        $file = $this->request->getFile('xlsx_file'); // Ambil file dari form
        if (!$file->isValid()) {
            return redirect()->back()->with('error_pegawai', 'File tidak valid');
        }

        // Validasi ekstensi file
        $ext = $file->getClientExtension();
        if ($ext !== 'xlsx') {
            return redirect()->back()->with('error_pegawai', 'Hanya file .xlsx yang diperbolehkan');
        }

        // Baca file Excel
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file->getTempName());
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        // Pastikan ada data di Excel
        if (count($data) <= 1) {
            return redirect()->back()->with('error_pegawai', 'File Excel kosong atau tidak valid');
        }

        $pegawaiModel = new PegawaiModel();
        $jabatanModel = new JabatanModel();
        $unitKerjaModel = new UnitKerjaModel();
        $statuspegawaiModel = new StatuspegawaiModel();
        $statuspernikahanModel = new StatuspernikahanModel();
        $jenjangpangkatModel = new JenjangpangkatModel();
        $agamaModel = new AgamaModel();
        $errors = [];

        // Ambil data status pernikahan dari database
        $statusPernikahanData = $statuspernikahanModel->findAll();
        $statusPernikahanMap = [];
        foreach ($statusPernikahanData as $status) {
            $statusPernikahanMap[$status['status']] = $status['kode'];
        }

        // Ambil data status pegawai dari database
        $statusPegawaiData = $statuspegawaiModel->findAll();
        $statusPegawaiMap = [];
        foreach ($statusPegawaiData as $status) {
            $statusPegawaiMap[$status['nama_status']] = $status['id'];
        }

        // Ambil data agama dari database
        $agamaData = $agamaModel->findAll();
        $agamaMap = [];
        foreach ($agamaData as $agama) {
            $agamaMap[$agama['nama_agama']] = $agama['kode'];
        }

        // Ambil data jenjang pangkat dari database
        $jenjangPangkatData = $jenjangpangkatModel->findAll();
        $jenjangPangkatMap = [];
        foreach ($jenjangPangkatData as $pangkat) {
            $jenjangPangkatMap[$pangkat['nama_pangkat']] = $pangkat['kode'];
        }

        // Ambil data golongan ruang dari database
        $golonganRuangData = $jenjangpangkatModel->findAll();
        $golonganRuangMap = [];
        foreach ($golonganRuangData as $golongan) {
            $golonganRuangMap[$golongan['golongan'] . '/' . $golongan['ruang']] = $golongan['golongan'] . $golongan['ruang'];
        }

        // Ambil data jabatan dari database
        $jabatanData = $jabatanModel->findAll();
        $jabatanMap = [];
        foreach ($jabatanData as $jabatan) {
            $jabatanMap[$jabatan['nama_jabatan']] = $jabatan['id'];
        }

        // Ambil data unit kerja dari database
        $unitKerjaData = $unitKerjaModel->findAll();
        $unitKerjaMap = [];
        foreach ($unitKerjaData as $unitkerja) {
            $unitKerjaMap[$unitkerja['nama_unit_kerja']] = $unitkerja['id'];
        }


        // Proses setiap baris data, mulai dari baris kedua (baris pertama biasanya header)
        foreach ($data as $index => $row) {
            if ($index === 0) {
                // Lewati baris header
                continue;
            }

            // Validasi panjang NIP
            if (strlen(trim($row[0])) < 10) {
                $errors[] = "NIP pada baris " . ($index + 1) . " kurang dari 10 karakter.";
                continue;
            }

            // Periksa apakah NIP sudah ada
            $existingPegawai = $pegawaiModel->where('nip', $row[0])->first();
            if ($existingPegawai) {
                $errors[] = "NIP {$row[0]} sudah terdaftar.";
                continue;
            }


            // Mapping status pegawai
            $statusPegawai = isset($statusPegawaiMap[$row[12]]) ? $statusPegawaiMap[$row[12]] : null;
            if ($statusPegawai === null) {
                $errors[] = "Status pegawai tidak valid.";
                continue;
            }

            // Mapping status pernikahan
            $statusPernikahan = isset($statusPernikahanMap[$row[13]]) ? $statusPernikahanMap[$row[13]] : null;
            if ($statusPernikahan === null) {
                $errors[] = "Status pernikahan tidak valid.";
                continue;
            }

            // Mapping agama
            $agama = isset($agamaMap[$row[15]]) ? $agamaMap[$row[15]] : null;
            if ($agama === null) {
                $errors[] = "Agama tidak valid.";
                continue;
            }

            // Mapping jenjang pangkat
            $jenjangPangkat = isset($jenjangPangkatMap[$row[6]]) ? $jenjangPangkatMap[$row[6]] : null;
            if ($jenjangPangkat === null) {
                $errors[] = "Jenjang pangkat tidak valid.";
                continue;
            }

            // Mapping golongan ruang
            $golonganRuang = isset($golonganRuangMap[$row[7]]) ? $golonganRuangMap[$row[7]] : null;
            if ($golonganRuang === null) {
                $errors[] = "Golongan ruang tidak valid.";
                continue;
            }

            // Mapping Unit Kerja
            $unitKerja = isset($unitKerjaMap[$row[9]]) ? $unitKerjaMap[$row[9]] : null;
            if ($unitKerja === null) {
                $errors[] = "Unit Kerja tidak valid.";
                continue;
            }

            // Mapping jabatan
            $jabatan = isset($jabatanMap[$row[8]]) ? $jabatanMap[$row[8]] : null;
            if ($jabatan === null) {
                $errors[] = "Jabatan tidak valid.";
                continue;
            }

            $pegawaiData = [
                'nip'               => $row[0],
                'gelar_depan'       => $row[1],
                'nama'              => $row[2],
                'gelar_belakang'    => $row[3],
                'tempat_lahir'      => $row[4],
                'tanggal_lahir'     => $row[5],
                'pangkat'           => $jenjangPangkat, // Simpan kode jenjang pangkat
                'golongan_ruang'    => $golonganRuang, // Simpan kode golongan ruang
                'jabatan_id'        => $jabatan, // Simpan nama lengkap jabatan
                'unit_kerja_id'     => $unitKerja, // Simpan nama lengkap unit kerja
                'kelas_jabatan'     => $row[10],
                'jenis_kelamin'     => $row[11],
                'status_pegawai'    => $statusPegawai, // Simpan kode status pegawai
                'status_pernikahan' => $statusPernikahan, // Simpan kode status pernikahan
                'jumlah_anak'       => $row[14],
                'agama'             => $agama, // Simpan kode agama
            ];

            // Simpan ke database
            $pegawaiModel->save($pegawaiData);
        }

        // Jika ada error, kirimkan pesan
        if (!empty($errors)) {
            return redirect()->back()->with('error_pegawai', implode('<br>', $errors));
        }

        return redirect()->back()->with('success_pegawai', 'Data Pegawai berhasil ditambahkan.');
    }
}
