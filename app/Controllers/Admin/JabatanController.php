<?php

namespace App\Controllers\Admin;

use App\Models\JabatanModel;
use App\Models\EselonModel;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatanModel = new JabatanModel();
        $eselonModel = new EselonModel();
        $search = $this->request->getGet('search');
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        if ($search) {
            $jabatan = $jabatanModel->getAllJabatan()->like('nama_jabatan', $search)->findAll();
        } else {
            $jabatan = $jabatanModel->findAll();
        }

        $data = [
            'jabatan' => $jabatan,
            'pager' => $jabatanModel->pager,
            'currentPage' => $currentPage,
            'search' => $search
        ];
        $data['eselons'] = $eselonModel->findAll();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_jabatan' => [
                'label' => 'Nama Jabatan',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Data tidak boleh kosong'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
        }
        // dd($data);
        return view('admin/jabatan/index', $data);
    }

    public function create()
    {
        $eselonModel = new EselonModel();
        $data['eselons'] = $eselonModel->findAll();
        return view('admin/jabatan/create', $data);
    }

    public function store()
    {

        $validation = \Config\Services::validation();

        // Validation rules for the form inputs
        $validation->setRules([
            'nama_jabatan' => [
                'label' => 'Nama Jabatan',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Jabatan harus diisi.'
                ]
            ],
            'tipe_jabatan' => [
                'label' => 'Tipe Jabatan',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tipe Jabatan harus diisi.'
                ]
            ],
            'eselon' => [
                'label' => 'Eselon',
                'rules' => 'permit_empty',
                'errors' => [
                    'required' => 'Eselon harus dipilih jika tipe jabatan adalah Struktural.'
                ]
            ]
        ]);

        if ($this->request->getPost('tipe_jabatan') === 'Struktural') {
            $validation->setRule('eselon', 'Eselon', 'required', [
                'required' => 'Eselon harus dipilih jika tipe jabatan adalah Struktural.'
            ]);
        }
    
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),
            ]);
        }



        $data = [
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'tipe_jabatan' => $this->request->getPost('tipe_jabatan'),
            'eselon' => $this->request->getPost('eselon'),
        ];

        $jabatanModel = new JabatanModel();
        $jabatanModel->insert($data);

        // Return success response
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data Jabatan berhasil disimpan.',
        ]);
    }

    public function edit($id)
    {
        $jabatanModel = new JabatanModel();
        $eselonModel = new EselonModel();
        $data['eselons'] = $eselonModel->findAll();
        $data['jabatan'] = $jabatanModel->find($id);
        return view('admin/jabatan/edit', $data);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();

        // Validation rules for the form inputs
        $validation->setRules([
            'nama_jabatan' => [
                'label' => 'Nama Jabatan',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Jabatan harus diisi.'
                ]
            ],
            'tipe_jabatan' => [
                'label' => 'Tipe Jabatan',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tipe Jabatan harus diisi.'
                ]
            ],
            'eselon' => [
                'label' => 'Eselon',
                'rules' => 'permit_empty',
                'errors' => [
                    'required' => 'Eselon harus dipilih jika tipe jabatan adalah Struktural.'
                ]
            ]
        ]);

        if ($this->request->getPost('tipe_jabatan') === 'Struktural') {
            $validation->setRule('eselon', 'Eselon', 'required', [
                'required' => 'Eselon harus dipilih jika tipe jabatan adalah Struktural.'
            ]);
        }
    
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),
            ]);
        }



        $data = [
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'tipe_jabatan' => $this->request->getPost('tipe_jabatan'),
            'eselon' => $this->request->getPost('eselon'),
        ];

        $jabatanModel = new JabatanModel();
        $jabatanModel->update($id, $data);

        // Return success response
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data Jabatan berhasil disimpan.',
        ]);
    }

    public function delete($id)
    {
        $jabatanModel = new JabatanModel();
        $jabatanModel->delete($id);
        return redirect()->to('/admin/jabatan');
    }

    public function uploadXlsx()
    {
        $file = $this->request->getFile('xlsx_file');

        if ($file->isValid() && !$file->hasMoved()) {
            $spreadsheet = IOFactory::load($file->getTempName());
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);


            $jabatanModel = new JabatanModel();

            foreach ($sheetData as $index => $data) {
                if ($index == 1) continue; // Lewati baris header

                // Validasi jabatan, unit kerja, dan unit kerjaa berdasarkan nama


                $jabatanModel->insert([
                    'nama_jabatan' => $data['A'],
                    'eselon' => $data['B'],
                    'is_fungsional' => $data['C'],
                    'is_pelaksana' => $data['D'],
                    'is_pppk' => $data['E'],
                    'is_non_asn' => $data['F']
                ]);
            }

            return redirect()->to('/admin/jabatan')->with('success', 'Data berhasil ditambahkan.');
        }

        return redirect()->to('/admin/jabatan')->with('error', 'Data gagal ditambahkan.');
    }
}
