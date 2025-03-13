<?php

namespace App\Controllers\Admin;

use App\Models\UnitkerjaModel;
use CodeIgniter\Controller;

class UnitkerjaController extends Controller
{

    public function index()
    {
        $unitkerjaModel = new UnitkerjaModel();
        $search = $this->request->getGet('search');
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        if ($search) {
            $unitkerja = $unitkerjaModel->like('nama_unit_kerja', $search)->paginate(100, 'default');
        } else {
            $unitkerja = $unitkerjaModel->paginate(100, 'default');
        }

        // Tambahkan parent_name
        foreach ($unitkerja as &$unit) {
            if (!empty($unit['parent_id'])) {
                $parent = $unitkerjaModel->getParentName($unit['parent_id']);
                $unit['parent_name'] = $parent ? $parent['nama_unit_kerja'] : 'Unknown Parent';
            } else {
                $unit['parent_name'] = 'Tidak Ada Induk';
            }
        }

        // Ambil semua unit kerja untuk modal
        $allUnitkerja = $unitkerjaModel->findAll(); // Mengambil semua unit kerja

        $data = [
            'unitkerja' => $unitkerja,
            'allUnitkerja' => $allUnitkerja, // Data unit kerja untuk dropdown
            'pager' => $unitkerjaModel->pager,
            'currentPage' => $currentPage,
            'search' => $search,
        ];

        return view('admin/unitkerja/index', $data);
    }

    public function create()
    {
        $unitkerjaModel = new UnitkerjaModel();
        $data = [
            'unitkerja' => $unitkerjaModel->findAll(), // Fetch all unit kerja
        ];
        $data['all_unit_kerja'] = $unitkerjaModel->findAll();
        return view('admin/unitkerja/create', $data);
    }

    public function store()
    {
        $unitkerjaModel = new UnitkerjaModel();

        // Data yang diambil dari form
        $data = [
            'nama_unit_kerja' => $this->request->getPost('nama_unit_kerja'),
            'parent_id' => $this->request->getPost('parent_id')
        ];

        // Aturan validasi
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_unit_kerja' => [
                'label' => 'Nama Unit Kerja',
                'rules' => 'required|alpha_space',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                    'alpha_space' => '{field} hanya boleh berisi huruf dan spasi.'
                ]
            ],
            'parent_id' => [
                'label' => 'Induk Unit Kerja',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Belum Di pilih.'
                ]
            ]
        ]);

        // Validasi input
        if (!$validation->run($data)) {
            // Jika validasi gagal
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->back()->withInput();
        }

        // Proses penyimpanan data
        try {
            if ($unitkerjaModel->save($data)) {
                session()->setFlashdata('success_unitkerja', 'Data Unit Kerja berhasil ditambahkan.');
            } else {
                session()->setFlashdata('error_unitkerja', 'Data Unit Kerja gagal ditambahkan.');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->to('/admin/unitkerja');
    }
    public function edit($id)
    {
        $unitkerjaModel = new UnitkerjaModel();
        // Find the unit kerja by ID
        $data['unitkerja'] = $unitkerjaModel->find($id);

        // If the unit kerja doesn't exist, redirect with an error message
        if (!$data['unitkerja']) {
            return redirect()->to('/admin/unitkerja')->with('error', 'Unit Kerja tidak ditemukan');
        }

        // Fetch all unit kerja for the parent select dropdown
        $data['all_unit_kerja'] = $unitkerjaModel->findAll();

        return view('admin/unitkerja/edit', $data);
    }

    public function update($id)
    {
        $unitkerjaModel = new UnitkerjaModel();

        // Ambil data input dari form
        $data = [
            'nama_unit_kerja' => $this->request->getPost('nama_unit_kerja'),
            'parent_id' => $this->request->getPost('parent_id')
        ];

        // Validasi input
        $validation = \Config\Services::validation();
        $rules = [
            'nama_unit_kerja' => 'required',
            'parent_id' => 'permit_empty|numeric'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error_unitkerja', 'Harap isi semua data dengan benar.');
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Proses update data
        try {
            $unitkerjaModel->update($id, $data);
            session()->setFlashdata('success_unitkerja', 'Data unit kerja berhasil diperbarui.');
        } catch (\Exception $e) {
            session()->setFlashdata('error_unitkerja', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }

        return redirect()->to('/admin/unitkerja');
    }

    public function delete($id)
    {
        $unitkerjaModel = new UnitkerjaModel();

        // Mengambil data berdasarkan ID dan melakukan soft delete
        if ($unitkerjaModel->delete($id)) {
            session()->setFlashdata('success_unitkerja', 'Unit Kerja berhasil dihapus.');
        } else {
            session()->setFlashdata('error_unitkerja', 'Gagal menghapus Unit Kerja.');
        }

        return redirect()->to('/admin/unitkerja');
    }
}
