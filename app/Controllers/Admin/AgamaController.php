<?php

namespace App\Controllers\Admin;

use App\Models\AgamaModel;
use CodeIgniter\Controller;


class AgamaController extends Controller
{


    public function index()
    {

        $agamaModel = new AgamaModel();

        $search = $this->request->getGet('search');
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        if ($search) {
            $agama = $agamaModel->like('nama_agama', $search)->paginate(20, 'default');
        } else {
            $agama = $agamaModel->paginate(20, 'default');
        }

        $data = [

            'pager' => $agamaModel->pager,
            'currentPage' => $currentPage,
            'search' => $search,
        ];


        $data['agama'] = $agamaModel->findAll();

        return view('admin/referensi/referensi', $data);
    }

    public function create()
    {
        $agamaModel = new AgamaModel();
        $data = [
            'agama' => $agamaModel->findAll(), // Fetch all unit kerja
        ];
        return view('admin/agama/create', $data);
    }

    public function store()
    {
        $agamaModel = new AgamaModel();

        $data = [
            'nama_agama' => $this->request->getPost('nama_agama'),
            'kode' => $this->request->getPost('kode')
        ];

        // Ambil data input
        $nama_agama = $this->request->getPost('nama_agama');
        $kode = $this->request->getPost('kode');

        // Validasi input
        if (empty($nama_agama) || empty($kode)) {
            session()->setFlashdata('error_agama', 'Nama agama dan kode tidak boleh kosong.');
            return redirect()->back()->withInput();
        }

        try {
            // Data untuk disimpan
            $data = [
                'nama_agama' => $this->request->getPost('nama_agama'),
                'kode' => $this->request->getPost('kode'),
            ];

            // Simpan data ke database
            $agamaModel->save($data);

            // Flashdata untuk pesan sukses
            session()->setFlashdata('success_agama', 'Agama berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Flashdata untuk pesan error
            session()->setFlashdata('error_agama', 'Terjadi kesalahan saat menambahkan Agama.');
        }
        return redirect()->to('/admin/referensi/referensi');
    }

    public function edit($id)
    {
        $agamaModel = new AgamaModel();
        $data['agama'] = $agamaModel->find($id);

        return view('admin/agama/edit', $data);
    }

    public function update($id)
    {
        $agamaModel = new AgamaModel();
        $data = [
            'nama_agama' => $this->request->getPost('nama_agama'),
            'kode' => $this->request->getPost('kode')
        ];

        // Validasi input
        if (empty($nama_agama) || empty($kode)) {
            session()->setFlashdata('error_agama', 'Nama agama dan kode tidak boleh kosong.');
            return redirect()->back()->withInput();
        }

        try {
            // Proses update data
            if ($agamaModel->update($id, $data)) {
                // Set flashdata success
                session()->setFlashdata('success_agama', 'Data agama berhasil diperbarui.');
            } else {
                // Set flashdata error jika gagal
                session()->setFlashdata('error_agama', 'Gagal memperbarui data agama.');
            }
        } catch (\Exception $e) {
            // Set flashdata error jika terjadi exception
            session()->setFlashdata('error_agama', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        // Redirect kembali ke halaman referensi
        return redirect()->to('/admin/referensi/referensi');
    }

    public function delete($id)
    {
        $agamaModel = new AgamaModel();
        $agamaModel->delete($id);
        return redirect()->to('/admin/referensi/referensi');
    }
}
