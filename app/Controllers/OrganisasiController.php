<?php

namespace App\Controllers;

use App\Models\PegawaiModel;
use App\Models\JabatanModel;
use App\Models\UnitKerjaModel; // Pastikan model unit kerja digunakan
use App\Models\JenjangpangkatModel;
use App\Models\OrganisasiModel;
use CodeIgniter\Controller;

class OrganisasiController extends BaseController
{
    protected $pegawaiModel;
    protected $jabatanModel;
    protected $unitKerjaModel;
    protected $jenjangpangkatModel;
    protected $organisasiModel;

    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
        $this->jabatanModel = new JabatanModel();
	$this->jenjangpangkatModel = new JenjangpangkatModel();
        $this->unitKerjaModel = new UnitKerjaModel();
        $this->organisasiModel = new OrganisasiModel();
    }

    public function index()
    {
        $PegawaiModel = new PegawaiModel();
        $organisasiModel = new OrganisasiModel();
        $search = $this->request->getGet('search');
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;


        if ($search) {
            $organisasi = $organisasiModel->like('nama', $search)->paginate(20, 'default');
        } else { 
            $organisasi = $organisasiModel->paginate(20, 'default');
        }
        
        $pegawaiEselon1 = $this->organisasiModel->geteselon1();

        $data = [
            'pangkat' => $this->organisasiModel->pangkat(),
        'pegawaieselon1' => $pegawaiEselon1,
        'jabatan' => $this->jabatanModel->findAll(),
        'unit_kerja' => $this->unitKerjaModel->findAll(),
        'organisasi' => $organisasi,
        'pager' => $organisasiModel->pager,
        'currentPage' => $currentPage,
        'search' => $search
        ];
        $data['pegawai'] = $this->organisasiModel->getAllPegawai();
// dd($data);
// dd($data['pegawai']);
// dd($pegawai);
// return view('organisasi/organisasi', ['pegawai' => $pegawai]);
        return view('organisasi/organisasi', $data);
    }

public function cekUnitKerja($unitKerjaId)
{
    $organisasiModel = new OrganisasiModel();

    // Cek apakah unit kerja tersebut ada
    $unitKerja = $organisasiModel->getUnitKerjaById($unitKerjaId);

    if (!$unitKerja) {
        return redirect()->back()->with('error', 'Unit kerja tidak ditemukan.');
    }

    // Cek apakah unit kerja memiliki parent_id (ini berarti unit kerja tersebut bukan unit kerja utama)
    if ($unitKerja['parent_id']) {
        // Jika unit kerja memiliki parent_id, kita cari pegawai eselon 2 yang terkait dengan unit kerja ini
        $pegawaiEselon2 = $organisasiModel->geteselon2ByUnit($unitKerjaId);
        
        $data = [
            'pegawaiEselon2' => $pegawaiEselon2
        ];
        return view('organisasi/pegawai/staffahli', $data);
    } else {
        // Jika unit kerja tidak memiliki parent_id, berarti itu adalah unit kerja utama (Eselon 1)
        return redirect()->back()->with('error', 'Unit kerja ini tidak memiliki anak unit kerja.');
    }
}

   public function sekretaris($pegawaiNama)
{
    $jenjangpangkatModel = new JenjangpangkatModel();
    if (!$pegawaiNama) {
        return redirect()->back()->with('error', 'Pegawai tidak ditemukan.');
    }

    $organisasiModel = new OrganisasiModel();

    // Get the main pegawai based on the name
    $pegawaiUtama = $organisasiModel->getPegawaiByNama($pegawaiNama);

    if (!$pegawaiUtama) {
        return redirect()->back()->with('error', "Pegawai tidak ditemukan.");
    }

    // Get related pegawai eselon 2 based on the unit kerja of the main pegawai
    $pegawaiEselon2 = $organisasiModel->getEselon2ByUnit($pegawaiUtama['unit_kerja_id']);

    // Simpan bawahan eselon III yang akan ditampilkan setelah klik
    $bawahan = [];
    foreach ($pegawaiEselon2 as $pegawai) {
        // Hanya ambil bawahan eselon III setelah tombol klik
        $bawahan[$pegawai['nama']] = $organisasiModel->getBawahanByUnit($pegawai['unit_kerja_id']);
    }

    $data = [
        'pegawaiUtama' => $pegawaiUtama,
        'relatedPegawai' => $pegawaiEselon2,  // Data eselon II yang ditampilkan pertama kali
        'relateddPegawai' => $bawahan,        // Bawahan eselon III yang akan muncul setelah tombol klik
    ];

    $data['jenjangpangkat'] = $jenjangpangkatModel->findAll();

    return view('organisasi/pegawai/staffahli', $data);
}

public function pegawai($namaJabatan, $pegawaiNama) 
{
    if (!$namaJabatan || !$pegawaiNama) {
        return redirect()->back()->with('error', 'Nama jabatan atau nama pegawai tidak ditemukan.');
    }

    $organisasiModel = new OrganisasiModel();

    // Ambil pegawai berdasarkan nama jabatan dan nama pegawai
    $pegawaiUtama = $organisasiModel->getPegawaies2ByNama($pegawaiNama);

    if (!$pegawaiUtama) {
        return redirect()->back()->with('error', "Pegawai tidak ditemukan.");
    }

    // Ambil data pegawai eselon 2 terkait unit kerja pegawai utama
    $pegawaiEselon2 = $organisasiModel->getpegawaieselon2(
        $pegawaiUtama['unit_kerja_id'], 
    );

    $data = [
        'pegawaiUtama' => $pegawaiUtama,
        'relatedPegawaies2' => $pegawaiEselon2,
    ];

    return view('organisasi/pegawai/pegawai', $data);
}

    public function cariPegawai()
{
    $search = $this->request->getGet('search');
    $pegawaiModel = new PegawaiModel();

    // Mencari data pegawai berdasarkan query search
    $pegawai = $pegawaiModel->like('nama', $search)->orLike('pangkat', $search)->findAll();

    return $this->response->setJSON($pegawai);
}

public function cariStaff()
{
    $search = $this->request->getGet('search');
    $pegawaiModel = new PegawaiModel();

    // Mencari data pegawai berdasarkan query search
    $pegawai = $pegawaiModel->like('nama', $search)->orLike('pangkat', $search)->findAll();

    return $this->response->setJSON($pegawai);
}

public function getPegawaiByPangkat()
{
    $pangkat = $this->request->getGet('pangkat');
    $pegawai = $this->pegawaiModel->where('pangkat', $pangkat)->first();
    
    return $this->response->setJSON($pegawai);
}


}

