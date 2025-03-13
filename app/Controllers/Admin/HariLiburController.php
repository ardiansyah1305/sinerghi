<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HariLiburModel;

class HariLiburController extends BaseController
{
    protected $hariLiburModel;
    
    public function __construct()
    {
        $this->hariLiburModel = new HariLiburModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Daftar Hari Libur',
            'hari_libur' => $this->hariLiburModel->findAll()
        ];
        
        return view('admin/hari_libur/index', $data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Tambah Hari Libur'
        ];
        
        return view('admin/hari_libur/create', $data);
    }
    
    public function store()
    {
        // Validasi input
        $rules = $this->hariLiburModel->getValidationRules();
        $messages = $this->hariLiburModel->getValidationMessages();
        
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Simpan data
        $this->hariLiburModel->save([
            'tanggal' => $this->request->getPost('tanggal'),
            'tentang' => $this->request->getPost('tentang')
        ]);
        
        return redirect()->to('admin/hari-libur')->with('success', 'Data hari libur berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $hariLibur = $this->hariLiburModel->find($id);
        
        if (!$hariLibur) {
            return redirect()->to('admin/hari-libur')->with('error', 'Data hari libur tidak ditemukan');
        }
        
        $data = [
            'title' => 'Edit Hari Libur',
            'hari_libur' => $hariLibur
        ];
        
        return view('admin/hari_libur/edit', $data);
    }
    
    public function update($id)
    {
        // Validasi input
        $rules = $this->hariLiburModel->getValidationRules();
        $messages = $this->hariLiburModel->getValidationMessages();
        
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Update data
        $this->hariLiburModel->update($id, [
            'tanggal' => $this->request->getPost('tanggal'),
            'tentang' => $this->request->getPost('tentang')
        ]);
        
        return redirect()->to('admin/hari-libur')->with('success', 'Data hari libur berhasil diperbarui');
    }
    
    public function delete($id)
    {
        $hariLibur = $this->hariLiburModel->find($id);
        
        if (!$hariLibur) {
            return redirect()->to('admin/hari-libur')->with('error', 'Data hari libur tidak ditemukan');
        }
        
        $this->hariLiburModel->delete($id);
        
        return redirect()->to('admin/hari-libur')->with('success', 'Data hari libur berhasil dihapus');
    }
    
    // API method to check if a date is a holiday
    public function isHoliday()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }
        
        $tanggal = $this->request->getPost('tanggal');
        
        if (!$tanggal) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tanggal tidak diberikan']);
        }
        
        $holiday = $this->hariLiburModel->where('tanggal', $tanggal)->first();
        
        if ($holiday) {
            return $this->response->setJSON([
                'status' => 'success',
                'is_holiday' => true,
                'holiday_info' => $holiday['tentang']
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'success',
                'is_holiday' => false
            ]);
        }
    }
    
    // API method to get all holidays
    public function getHolidays()
    {
        $holidays = $this->hariLiburModel->findAll();
        
        return $this->response->setJSON([
            'status' => 'success',
            'holidays' => $holidays
        ]);
    }
}
