<?php

namespace App\Controllers\Admin;

use App\Models\StatusModel;
use CodeIgniter\Controller;


class statuspegawaiController extends Controller
{   
    

    public function index()
{
    $PegawaiModel = new PegawaiModel();
    $statuspegawaiModel = new StatuspegawaiModel();
    $statuspernikahanModel = new StatuspernikahanModel();
    $jenjangpangkatModel = new JenjangpangkatModel();
    $agamaModel = new AgamaModel();
    $search = $this->request->getGet('search');
    $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

    if ($search) {
        $statuspegawai = $statusmodel->like('nama_status', $search)->paginate(20, 'default');
    } else {
        $statuspegawai = $statusmodel->paginate(20, 'default');
    }

    $data = [
        
        'pager' => $statusmodel->pager,
        'currentPage' => $currentPage,
        'search' => $search,
    ];

    $data['pegawai'] = $this->pegawaiModel->findAll();
    $data['statuspegawai'] = $statuspegawaiModel->findAll();
    $data['statuspernikahan'] = $statuspernikahanModel->findAll();
    $data['jenjangpangkat'] = $jenjangpangkatModel->findAll();
    $data['agama'] = $agamaModel->findAll();

    return view('admin/referensi/referensi', $data);
}

    public function create()
{
    $statusmodel = new StatusModel();
    $data = [
        'statuspegawai' => $statusmodel->findAll(), // Fetch all unit kerja
    ];
    return view('admin/statuspegawai/create', $data);
}

    public function store()
    {
        $unitkerjaModel = new UnitkerjaModel();
        $data = [
            'nama_unit_kerja' => $this->request->getPost('nama_unit_kerja'),
            'parent_id' => $this->request->getPost('parent_id')
        ];

        // Ambil data input
        $namaUnitKerja = $this->request->getPost('nama_unit_kerja');
        $parentId = $this->request->getPost('parent_id');

        // Validasi
        $validation =  \Config\Services::validation();

        $rules = [
            'nama_unit_kerja' => 'required',
            'parent_id' => 'required',
        ];

    if (!$this->validate($rules)) {
        // Jika validasi gagal, kembalikan ke form dengan pesan error
        return redirect()->back()->withInput()->with('validation', $this->validator);
    }

    // Simpan data ke database jika valid
    // ...

        $unitkerjaModel->save($data);
        return redirect()->to('/admin/unitkerja');
    }

    public function edit($id)
{
    $unitkerjaModel = new UnitkerjaModel();
    $data['unitkerja'] = $unitkerjaModel->find($id);
    $data['all_unit_kerja'] = $unitkerjaModel->findAll(); // Fetch all unit kerja

    return view('admin/unitkerja/edit', $data);
}

    public function update($id)
    {
        $unitkerjaModel = new UnitkerjaModel();
        $data = [
            'nama_unit_kerja' => $this->request->getPost('nama_unit_kerja'),
            'parent_id' => $this->request->getPost('parent_id')
        ];

        $unitkerjaModel->update($id, $data);
        return redirect()->to('/admin/unitkerja');
    }

    public function delete($id)
    {
        $unitkerjaModel = new UnitkerjaModel();
        $unitkerjaModel->delete($id);
        return redirect()->to('/admin/unitkerja');
    }
}
