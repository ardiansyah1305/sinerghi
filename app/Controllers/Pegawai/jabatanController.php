<?php

namespace App\Controllers\Pegawai;

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
            $jabatan = $jabatanModel->like('nama_jabatan', $search)->findAll();
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

        return view('pegawai/jabatan/index', $data);
    }

    public function create()
    {
        $data['eselons'] = $eselonModel->findAll();
        return view('pegawai/jabatan/create');
    }

    public function store()
    {
        $jabatanModel = new JabatanModel();
	$jabatanradio = $this->request->getPost('jabatanradio');

        $data = [
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'eselon' => $this->request->getPost('eselon'),
            'is_fungsional' => $jabatanradio === 'fungsional' ? 1 : 0,
            'is_pelaksana' => $jabatanradio === 'pelaksana' ? 1 : 0,
            'is_pppk' => $jabatanradio === 'pppk' ? 1 : 0,
            'is_non_asn' => $jabatanradio === 'non_asn' ? 1 : 0,
        ];

        try {
            if ($jabatanModel->save($data)) {
                session()->setFlashdata('success_jabatan', 'Data Jabatan berhasil ditambahkan.');
            } else {
                session()->setFlashdata('error_jabatan', 'Data Jabatan gagal ditambahkan.');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error_jabatan', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        return redirect()->to('/pegawai/jabatan');
    }

    public function edit($id)
    {
        $jabatanModel = new JabatanModel();
        $data['jabatan'] = $jabatanModel->find($id);
        return view('pegawai/jabatan/edit', $data);
    }

    public function update($id)
    {
        $jabatanModel = new JabatanModel();
	$jabatanradio = $this->request->getPost('jabatanradio');

        // Ambil data input dari form
    	$nama_jabatan = trim($this->request->getPost('nama_jabatan')); // Trim untuk menghapus spasi di awal/akhir
    	$data = [
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'eselon' => $this->request->getPost('eselon'),
            'is_fungsional' => $jabatanradio === 'fungsional' ? 1 : 0,
            'is_pelaksana' => $jabatanradio === 'pelaksana' ? 1 : 0,
            'is_pppk' => $jabatanradio === 'pppk' ? 1 : 0,
            'is_non_asn' => $jabatanradio === 'non_asn' ? 1 : 0,
        ];

	// Validasi input nama_jabatan
    	if ($nama_jabatan === '') {
            return redirect()->back()->withInput()->with('error_jabatan', 'Nama Jabatan tidak boleh kosong.');
    	}

    	if (!preg_match('/^[a-zA-Z\s,]+$/', $nama_jabatan)) {
            return redirect()->back()->withInput()->with('error_jabatan', 'Nama Jabatan hanya boleh berisi huruf dan tanda koma.');
    	}

        if ($jabatanModel->update($id, $data)) {
            return redirect()->to('/pegawai/jabatan')->with('success_jabatan', 'Data berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error_jabatan', 'Gagal memperbarui data.');
        }
        //return redirect()->to('/pegawai/jabatan');
    }

    public function delete($id)
    {
        $jabatanModel = new JabatanModel();
        $jabatanModel->delete($id);
        return redirect()->to('/pegawai/jabatan');
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
            
            return redirect()->to('/pegawai/jabatan')->with('success', 'Data berhasil ditambahkan.');
        }
        
        return redirect()->to('/pegawai/jabatan')->with('error', 'Data gagal ditambahkan.');
    }
}
