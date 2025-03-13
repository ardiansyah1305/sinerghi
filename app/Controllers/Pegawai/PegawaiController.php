<?php

namespace App\Controllers\Pegawai;

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
    protected $unitKerjaModel;
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
        $this->unitKerjaModel = new UnitKerjaModel();
    }

    public function index()
{
    $search = $this->request->getGet('search');
    $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

    $pegawai = $this->pegawaiModel->getAllPegawai();  
    
    if ($search) {
        $pegawai = $this->pegawaiModel->searchPegawai($search);
    }
    

    $data = [
        'pegawai' => $pegawai,
        'jabatan' => $this->jabatanModel->findAll(),
        'unit_kerja' => $this->unitKerjaModel->findAll(),
        'pager' => $this->pegawaiModel->pager,
        'currentPage' => $currentPage,
        'search' => $search,
    ];

   $data['statuspegawai'] = $this->statuspegawaiModel->findAll();
   $data['statuspernikahan'] = $this->statuspernikahanModel->findAll();
   $data['jenjangpangkat'] = $this->jenjangpangkatModel->findAll();
   $data['agama'] = $this->agamaModel->findAll();
   $data['users'] = $this->userModel->findAll();
    
    return view('pegawai/pegawai/index', $data);
}

public function check_nip() {
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
        $data = [
            'jabatan' => $this->jabatanModel->findAll(),
            'unit_kerja' => $this->unitKerjaModel->findAll(),
        ];
        $data['statuspegawai'] = $this->statuspegawaiModel->findAll();
        $data['statuspernikahan'] = $this->statuspernikahanModel->findAll();
        $data['jenjangpangkat'] = $this->jenjangpangkatModel->findAll();
        $data['agama'] = $this->agamaModel->findAll();
        
        return view('pegawai/pegawai/create', $data);
    }

public function store()
{
    $pegawaiModel = new PegawaiModel();

    // Ambil data NIP dari request
    $nip = $this->request->getPost('nip');
    if (!$nip) {
        return redirect()->back()->with('error_pegawai', 'NIP tidak boleh kosong!')->withInput();
    }

    // Cek apakah NIP sudah ada di database
    $existingPegawai = $pegawaiModel->where('nip', $nip)->first();
    if ($existingPegawai) {
        return redirect()->back()->with('error_pegawai', 'NIP sudah terdaftar!')->withInput();
    }

    // Validasi upload file (jika ada)
    $file = $this->request->getFile('foto');
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        $file->move(FCPATH . 'img', $newName); // Simpan file di folder public/img
    } else {
        $newName = null;
    }

    // Siapkan data untuk disimpan
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
        'foto' => $newName,
        'agama' => $this->request->getPost('agama'),
        'deleted_at' => '0000-00-00 00:00:00',
    ];

    try {
        $pegawaiModel->save($data);
        return redirect()->to('/pegawai/pegawai')->with('success_pegawai', 'Pegawai berhasil ditambahkan!');
    } catch (\Exception $e) {
        return redirect()->to('/pegawai/pegawai')->with('error_pegawai', 'Terjadi kesalahan saat menambahkan pegawai.');
    }
}

    
    public function edit($id)
{
    $pegawaiModel = new PegawaiModel();
    $statuspegawaiModel = new StatuspegawaiModel();
    $statuspernikahanModel = new StatuspernikahanModel();
    $jenjangpangkatModel = new JenjangpangkatModel();
    $unitKerjaModel = new UnitKerjaModel();
    $agamaModel = new AgamaModel();

    $data['pegawai'] = $pegawaiModel->find($id);
    $data['statuspegawai'] = $statuspegawaiModel->findAll();
    $data['statuspernikahan'] = $statuspernikahanModel->findAll();
    $data['jenjangpangkat'] = $jenjangpangkatModel->findAll();
    $data['agama'] = $agamaModel->findAll();
    $data['unit_kerja'] = $unitKerjaModel->findAll(); // Data semua unit kerja

    return view('pegawai/pegawai/edit', $data);
}
 

    public function update($id)
    {
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
            // 'foto' => $newName,
            // 'foto' => $this->request->getPost('foto'),

            'agama' => $this->request->getPost('agama'),
            'deleted_at' => '0000-00-00 00:00:00',
        ];

        $file = $this->request->getFile('foto');
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        $file->move(FCPATH . 'img', $newName);
        $data['foto'] = $newName;
    }

        try {
        	$this->pegawaiModel->update($id, $data);
        	session()->setFlashdata('success_pegawai', 'Data pegawai berhasil diperbarui.');
    	} catch (\Exception $e) {
        	session()->setFlashdata('error_pegawai', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
    	}
        return redirect()->to('/pegawai/pegawai');
    }

    public function delete($id)
{
    $this->pegawaiModel->delete($id); // Soft delete, tidak menghapus data secara permanen
    return redirect()->to('/pegawai/pegawai')->with('message', 'Data berhasil dihapus.');
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
}