<?php

namespace App\Controllers\Admin;

use App\Models\StatuspernikahanModel;
use CodeIgniter\Controller;


class StatuspernikahanController extends Controller
{   
    

    public function index()
{
    
   
    $statuspernikahanModel = new StatuspernikahanModel();
    
    $search = $this->request->getGet('search');
    $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

    if ($search) {
        $statuspernikahan = $statuspernikahanModel->like('status', $search)->paginate(20, 'default');
    } else {
        $statuspernikahan = $statuspernikahanModel->paginate(20, 'default');
    }

    $data = [
        
        'pager' => $statuspernikahanModel->pager,
        'currentPage' => $currentPage,
        'search' => $search,
    ];

    
    $data['statuspernikahan'] = $statuspernikahanModel->findAll();

    return view('admin/referensi/referensi', $data);
}

    public function create()
{
    $statuspernikahanModel = new StatuspernikahanModel();
    $data = [
        'statuspernikahan' => $statuspernikahanModel->findAll(), // Fetch all unit kerja
    ];
    return view('admin/statuspernikahan/create', $data);
}

    public function store()
    {
        $statuspernikahanModel = new StatuspernikahanModel();

        // Ambil data input
        $status = $this->request->getPost('status');
        $kode = $this->request->getPost('kode');

        // Validasi
        $validation =  \Config\Services::validation();

        $rules = [
            'status' => 'required',
            'kode' => 'required',
        ];

        // Validasi input
    	if (empty($status) || empty($kode)) {
        	session()->setFlashdata('error_status', 'Status dan kode tidak boleh kosong.');
        	return redirect()->back()->withInput();
    	}

        try {
            // Data untuk disimpan
            $data = [
                'status' => $this->request->getPost('status'),
                'kode' => $this->request->getPost('kode'),
            ];

            // Simpan data ke database
            $statuspernikahanModel->save($data);

            // Flashdata untuk pesan sukses
            session()->setFlashdata('success_status', 'Status pernikahan berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Flashdata untuk pesan error
            session()->setFlashdata('error_status', 'Terjadi kesalahan saat menambahkan Status Pernikahan.');
        }

        return redirect()->to('/admin/referensi/referensi');
    }

    public function edit($id)
{
    $statuspernikahanModel = new StatuspernikahanModel();
    $data['statuspernikahan'] = $statuspernikahanModel->find($id);

    return view('admin/statuspernikahan/edit', $data);
}

    public function update($id)
{
    $statuspernikahanModel = new StatuspernikahanModel();
    $data = [
        'status' => $this->request->getPost('status'),
        'kode' => $this->request->getPost('kode')
    ];

    // Validasi input
    if (empty($status) || empty($kode)) {
        session()->setFlashdata('error_status', 'Status dan kode tidak boleh kosong.');
        return redirect()->back()->withInput();
    }

    try {
        // Proses update data
        if ($statuspernikahanModel->update($id, $data)) {
            // Set flashdata success
            session()->setFlashdata('success_status', 'Data status pernikahan berhasil diperbarui.');
        } else {
            // Set flashdata error jika gagal
            session()->setFlashdata('error_status', 'Gagal memperbarui data status pernikahan.');
        }
    } catch (\Exception $e) {
        // Set flashdata error jika terjadi exception
        session()->setFlashdata('error_status', 'Terjadi kesalahan: ' . $e->getMessage());
    }

    // Redirect kembali ke halaman referensi
    return redirect()->to('/admin/referensi/referensi');
}

    public function delete($id)
    {
        $statuspernikahanModel = new StatuspernikahanModel();
        $statuspernikahanModel->delete($id);
        return redirect()->to('/admin/referensi/referensi');
    }
}
