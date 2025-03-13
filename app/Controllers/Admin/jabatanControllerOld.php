<?php

namespace App\Controllers\Admin;

use App\Models\JabatanModel;
use CodeIgniter\Controller;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatanModel = new JabatanModel();
        $search = $this->request->getGet('search');
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        if ($search) {
            $jabatan = $jabatanModel->like('nama_pejabat', $search)->paginate(20, 'default');
        } else {
            $jabatan = $jabatanModel->paginate(20, 'default');
        }

        $data = [
            'jabatan' => $jabatan,
            'pager' => $jabatanModel->pager,
            'currentPage' => $currentPage,
            'search' => $search
        ];

        return view('admin/jabatan/index', $data);
    }

    public function create()
    {
        return view('admin/jabatan/create');
    }

    public function store()
    {
        $jabatanModel = new JabatanModel();
        $data = [
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'is_fungsional' => $this->request->getPost('is_fungsional'),
            'is_pelaksana' => $this->request->getPost('is_pelaksana'),
            'eselon' => $this->request->getPost('eselon'),
            'is_pjp' => $this->request->getPost('is_pjp'),
            'is_pppk' => $this->request->getPost('is_pppk')
        ];
        $jabatanModel->save($data);
        return redirect()->to('/admin/jabatan');
    }

    public function edit($id)
    {
        $jabatanModel = new JabatanModel();
        $data['jabatan'] = $jabatanModel->find($id);
        return view('admin/jabatan/edit', $data);
    }

    public function update($id)
    {
        $jabatanModel = new JabatanModel();
        $data = [
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'is_fungsional' => $this->request->getPost('is_fungsional'),
            'is_pelaksana' => $this->request->getPost('is_pelaksana'),
            'eselon' => $this->request->getPost('eselon'),
            'is_pjp' => $this->request->getPost('is_pjp'),
            'is_pppk' => $this->request->getPost('is_pppk'),
            'status' => $this->request->getPost('status'),
            'jabatan_struktural' => $this->request->getPost('jabatan_struktural'),
        ];

        $jabatanModel->update($id, $data);
        return redirect()->to('/admin/jabatan');
    }

    public function delete($id)
    {
        $jabatanModel = new JabatanModel();
        $jabatanModel->delete($id);
        return redirect()->to('/admin/jabatan');
    }
}
