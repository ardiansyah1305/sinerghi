<?php

namespace App\Controllers\Admin;

use App\Models\UnitKerjaaModel;
use App\Models\UnitKerjaModel; // Pastikan model unit kerja digunakan
use CodeIgniter\Controller;

class UnitkerjaaController extends Controller
{
    protected $unitkerjaaModel;
    protected $unitKerjaModel;

    public function __construct()
    {
        $this->unitkerjaaModel = new UnitkerjaaModel();
        $this->unitKerjaModel = new UnitKerjaModel();
    }

    public function index()
    {
        $unitkerjaaModel = new UnitkerjaaModel();
        $search = $this->request->getGet('search');
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        if ($search) {
            $uk = $this->unitkerjaaModel->like('nama_unit_kerja', $search)->paginate(20, 'default');
        } else {
            $uk = $this->unitkerjaaModel->paginate(20, 'default');
            
        }

        $data = [
            'unit_kerjaa' => $this->unitkerjaaModel->select('unit_kerjaa.*, unit_kerja.nama_unit_kerja AS nama_unit_kerja_utama')
                ->join('unit_kerja', 'unit_kerjaa.unit_kerja_id = unit_kerja.id')
                ->findAll(),
                'unit_kerja' => $this->unitKerjaModel->findAll(),
                // 'unit_kerjaa' => $this->unitKerjaaModel->findAll(),
            'pager' => $this->unitkerjaaModel->pager,
            'currentPage' => $currentPage,
            'search' => $search
        ];

        // $data['unit_kerjaa'] = $this->unitkerjaaModel->findAll();
        // $data['unit_kerja'] = $this->unitkerjaModel->findAll();

        return view('admin/unitkerjaa/index', $data);
    }

    public function create()
    {
        $data['unit_kerjaa'] = $this->unitkerjaaModel->findAll();
        $data['unit_kerja'] = $this->unitKerjaModel->findAll();

        return view('admin/unitkerjaa/create', $data);
    }

    public function store()
    {
        $UnitkerjaaModel = new UnitkerjaaModel();
        
        $data = [
            'nama_unit_kerja' => $this->request->getPost('nama_unit_kerja'),
            'parent_id' => $this->request->getPost('parent_id'),
            'unit_kerja_id' => $this->request->getPost('unit_kerja_id')
        ];
        $UnitkerjaaModel->save($data);
    
        return redirect()->to('/admin/unitkerjaa');
    }

    public function edit($id)
    {
        $UnitkerjaaModel = new UnitkerjaaModel();
        $data['unit_kerjaa'] = $UnitkerjaaModel->find($id);
        return view('admin/unitkerjaa/edit', $data);
    }

    public function update($id)
    {
        $UnitkerjaaModel = new UnitkerjaaModel();
        $data = [
            'nama_unit_kerja' => $this->request->getPost('nama_unit_kerja'),
            'parent_id' => $this->request->getPost('parent_id'),
            'unit_kerja_id' => $this->request->getPost('unit_kerja_id')
        ];
        
        
        $UnitkerjaaModel->update($id, $data);
    
        return redirect()->to('/admin/unitkerjaa');
    }

    public function delete($id)
    {
        $UnitkerjaaModel = new UnitkerjaaModel();
        $UnitkerjaaModel->delete($id);
        return redirect()->to('/admin/unitkerjaa');
    }
}
