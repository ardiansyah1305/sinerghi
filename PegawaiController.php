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
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
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

        $PegawaiModel = new PegawaiModel();
        $statuspegawaiModel = new StatuspegawaiModel();
        $statuspernikahanModel = new StatuspernikahanModel();
        $jenjangpangkatModel = new JenjangpangkatModel();
        $agamaModel = new AgamaModel();
        $userModel = new UserModel();
        $search = $this->request->getGet('search');
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        $pegawai = $this->pegawaiModel->getAllPegawai();

        if ($search) {
            $pegawai->like('pegawai.nama', $search);
        }



        $data = [
            'baseURL' => base_url(),
            'pegawai' => $pegawai,
            'jabatan' => $this->jabatanModel->findAll(),
            'unit_kerja' => $this->unitKerjaModel->findAll(),
            'pager' => $PegawaiModel->pager,
            'currentPage' => $currentPage,
            'search' => $search,
        ];

        $data['statuspegawai'] = $statuspegawaiModel->findAll();
        $data['statuspernikahan'] = $statuspernikahanModel->findAll();
        $data['jenjangpangkat'] = $jenjangpangkatModel->findAll();
        $data['agama'] = $agamaModel->findAll();
        $data['users'] = $userModel->findAll();

        return view('pegawai/pegawai/index', $data);
    }

    public function create()
    {
        $statuspernikahanModel = new StatuspernikahanModel();
        $jenjangpangkatModel = new JenjangpangkatModel();
        $statuspegawaiModel = new StatuspegawaiModel();
        $agamaModel = new AgamaModel();
        $userModel = new UserModel();
        $data = [
            'jabatan' => $this->jabatanModel->findAll(),
            'unit_kerja' => $this->unitKerjaModel->findAll(),
        ];
        $data['statuspegawai'] = $statuspegawaiModel->findAll();
        $data['statuspernikahan'] = $statuspernikahanModel->findAll();
        $data['jenjangpangkat'] = $jenjangpangkatModel->findAll();
        $data['agama'] = $agamaModel->findAll();
        $data['users'] = $userModel->findAll();
        return view('pegawai/pegawai/create', $data);
    }

    public function getNipList()
    {
        $userModel = new \App\Models\UserModel();
        $nipList = $userModel->select('nip')->findAll();

        return $this->response->setJSON($nipList);
    }


    public function store()
    {
        $pegawaiModel = new PegawaiModel();


        // Ambil ID dari input
        $unitKerjaId = $this->request->getPost('unit_kerja_id');

        $nip = $this->request->getPost('nip');
        if (!$nip) {
            return redirect()->back()->with('error', 'NIP tidak boleh kosong!');
        }

        // Cek apakah ID unit kerja dan unit kerja tambahan valid


        $file = $this->request->getFile('foto');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'img', $newName); // Simpan di folder public/uploads

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
                'unit_kerja_id' => $unitKerjaId,
                'kelas_jabatan' => $this->request->getPost('kelas_jabatan'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'status_pegawai' => $this->request->getPost('status_pegawai'),
                'status_pernikahan' => $this->request->getPost('status_pernikahan'),
                'jumlah_anak' => $this->request->getPost('jumlah_anak'),
                'foto' => $newName,
                'agama' => $this->request->getPost('agama'),
                'deleted_at' => '0000-00-00 00:00:00',
            ];



            $pegawaiModel->save($data);
        }
        return redirect()->to('/pegawai/pegawai');
    }

    public function edit($id)
    {
        $PegawaiModel = new PegawaiModel();
        $data['pegawai'] = $PegawaiModel->find($id);
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

        $this->pegawaiModel->update($id, $data);
        return redirect()->to('/pegawai/pegawai');
    }

    public function delete($id)
    {
        $this->pegawaiModel->delete($id); // Soft delete, tidak menghapus data secara permanen
        return redirect()->to('/pegawai/pegawai')->with('message', 'Data berhasil dihapus.');
    }


    public function uploadXlsx()
    {
        $file = $this->request->getFile('xlsx_file');

        if ($file->isValid() && !$file->hasMoved()) {
            $spreadsheet = IOFactory::load($file->getTempName());
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            $pegawaiModel = new PegawaiModel();
            $jabatanModel = new JabatanModel();
            $unitKerjaModel = new UnitKerjaModel();
            $unitKerjaaModel = new UnitKerjaaModel();

            foreach ($sheetData as $index => $data) {
                if ($index == 1)
                    continue; // Lewati baris header

                // Validasi jabatan, unit kerja, dan unit kerjaa berdasarkan nama
                // Validasi jabatan, unit kerja, dan unit kerjaa berdasarkan id
                $jabatan = $jabatanModel->find($data['I']);
                $unitKerja = $unitKerjaModel->find($data['J']);
                $unitKerjaa = $unitKerjaaModel->find($data['K']);


                $pegawaiModel->insert([
                    'nip' => $data['A'],
                    'gelar_depan' => $data['B'],
                    'nama' => $data['C'],
                    'gelar_belakang' => $data['D'],
                    'tempat_lahir' => $data['E'],
                    'tanggal_lahir' => $data['F'],
                    'pangkat' => $data['G'],
                    'golongan_ruang' => $data['H'],
                    'jabatan_id' => $jabatan ? $jabatan['id'] : null,
                    'unit_kerja_id' => $unitKerja ? $unitKerja['id'] : null,
                    'kelas_jabatan' => $data['L'],
                    'jenis_kelamin' => $data['M'],
                    'status_pegawai' => $data['N'],
                    'status_pernikahan' => $data['O'],
                    'jumlah_anak' => $data['P'],
                    'agama' => $data['Q']
                ]);
            }

            return redirect()->to('/pegawai/pegawai')->with('success', 'Data berhasil ditambahkan.');
        }

        return redirect()->to('/pegawai/pegawai')->with('error', 'Data gagal ditambahkan.');
    }



}