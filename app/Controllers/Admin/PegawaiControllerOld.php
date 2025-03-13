<?php

namespace App\Controllers\Admin;

use App\Models\PegawaiModel;
use App\Models\JabatanModel;
use App\Models\UnitKerjaModel; // Pastikan model unit kerja digunakan
use CodeIgniter\Controller;

class PegawaiController extends Controller
{
    protected $pegawaiModel;
    protected $jabatanModel;
    protected $unitKerjaModel;

    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
        $this->jabatanModel = new JabatanModel();
        $this->unitKerjaModel = new UnitKerjaModel();
    }

    public function index()
    {

        $PegawaiModel = new PegawaiModel();
        $search = $this->request->getGet('search');
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        if ($search) {
            $pgw = $PegawaiModel->like('nama', $search)->paginate(20, 'default');
        } else {
            $pgw = $PegawaiModel->paginate(20, 'default');
        }

        $data = [
            
            'pegawai' => $this->pegawaiModel->select('pegawai.*, jabatan.nama_jabatan, unit_kerja.nama_unit_kerja')
                ->join('jabatan', 'pegawai.id = pegawai.jabatan_id')
                ->join('unit_kerja', 'pegawai.id = pegawai.unit_kerja_id')
                ->findAll(),
                'jabatan' => $this->jabatanModel->findAll(),
                'unit_kerja' => $this->unitKerjaModel->findAll(),
            'pager' => $PegawaiModel->pager,
            'currentPage' => $currentPage,
            'search' => $search
        ];

        $data['pegawai'] = $this->pegawaiModel->findAll();

        dd($data);
        // return view('admin/pegawai/index', $data);
    }

    public function create()
    {
        $data['pegawai'] = $this->pegawaiModel->findAll();

        return view('admin/pegawai/create', $data);
    }

    public function store()
    {
        $pegawaiModel = new PegawaiModel();
        $file = $this->request->getFile('foto');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'img', $newName); // Simpan di folder public/uploads
        $data = [
            'nip' => $this->request->getPost('nip'),
            'gelar_depan' => $this->request->getPost('gelar_depan'),
            'nama' => $this->request->getPost('nama'),
            'gelar_belakang' => $this->request->getPost('gelar_belakang'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'pangkat' => $this->request->getPost('pangkat'),
            'golongan_ruang' => $this->request->getPost('golongan_ruang'),
            'jabatan_id' => $this->request->getPost('jabatan_id'),
            'unit_kerja_id' => $this->request->getPost('unit_kerja_id'),
            'kelas_jabatan' => $this->request->getPost('kelas_jabatan'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'is_active' => $this->request->getPost('is_active'),
            'total_angka_kredit' => $this->request->getPost('total_angka_kredit'),
            'status_pernikahan' => $this->request->getPost('status_pernikahan'),
            'foto' => $newName,
            'saldo_cuti' => $this->request->getPost('saldo_cuti'),
            'agama' => $this->request->getPost('agama'),
        ];
        $pegawaiModel->save($data);
    }
        return redirect()->to('/admin/pegawai');
    }

    public function edit($id)
    {
        $PegawaiModel = new PegawaiModel();
        $data['pegawai'] = $PegawaiModel->find($id);
        return view('admin/pegawai/edit', $data);
    }

    public function update($id)
    {
    //     $PegawaiModel = new PegawaiModel();
        
    //     $password = $this->request->getPost('password');
    //     if (!empty($password)) {
    //         $data['password'] = password_hash($password, PASSWORD_DEFAULT);
    //     } $data = [
    //         'nip' => $this->request->getPost('nip'),
    //         'gelar_depan' => $this->request->getPost('gelar_depan'),
    //         'nama' => $this->request->getPost('nama'),
    //         'gelar_belakang' => $this->request->getPost('gelar_belakang'),
    //         'role' => $this->request->getPost('role'),
    //         'tempat_lahir' => $this->request->getPost('tempat_lahir'),
    //         'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
    //         'pangkat' => $this->request->getPost('pangkat'),
    //         'golongan_ruang' => $this->request->getPost('golongan_ruang'),
    //         'jabatan_id' => $this->request->getPost('jabatan_id'),
    //         'unit_kerja_id' => $this->request->getPost('unit_kerja_id'),
    //         'kelas_jabatan' => $this->request->getPost('kelas_jabatan'),
    //         'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
    //         'is_active' => $this->request->getPost('is_active'),
    //         'total_angka_kredit' => $this->request->getPost('total_angka_kredit'),
    //         'status_pernikahan' => $this->request->getPost('status_pernikahan'),
    //         'foto' => $newName,
    //         'saldo_cuti' => $this->request->getPost('saldo_cuti'),
    //         'agama' => $this->request->getPost('agama'),
    //     ];
    //     if ($foto) {
    //         $file = $this->request->getFile('foto');
    //         if ($file && $file->isValid() && !$file->hasMoved()) {
    //             $newName = $file->getRandomName();
    //             $file->move(FCPATH . 'img', $newName);
    //             @unlink(FCPATH . 'img/' . $foto['foto']);
    //             $foto['foto'] = $newName;
    //         }
        
    //     $PegawaiModel->update($id, $data);
    // }
    //     return redirect()->to('/admin/pegawai');
    }

    public function delete($id)
    {
        $PegawaiModel = new PegawaiModel();
        $PegawaiModel->delete($id);
        return redirect()->to('/admin/pegawai');
    }
}
