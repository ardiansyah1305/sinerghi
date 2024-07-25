<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
    public function index()
    {
        $userModel = new UserModel();
        $search = $this->request->getGet('search');
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        if ($search) {
            $users = $userModel->like('nama', $search)->paginate(20, 'default');
        } else {
            $users = $userModel->paginate(20, 'default');
        }

        $data = [
            'users' => $users,
            'pager' => $userModel->pager,
            'currentPage' => $currentPage,
            'search' => $search
        ];

        return view('admin/users/index', $data);
    }

    public function create()
    {
        return view('admin/users/create');
    }

    public function store()
    {
        $userModel = new UserModel();
        $data = [
            'nip' => $this->request->getPost('nip'),
            'gelar_depan' => $this->request->getPost('gelar_depan'),
            'nama' => $this->request->getPost('nama'),
            'gelar_belakang' => $this->request->getPost('gelar_belakang'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'kode_bidang' => $this->request->getPost('kode_bidang'),
            'status' => $this->request->getPost('status'),
            'jabatan_struktural' => $this->request->getPost('jabatan_struktural'),
        ];
        $userModel->save($data);
        return redirect()->to('/admin/users');
    }

    public function edit($id)
    {
        $userModel = new UserModel();
        $data['user'] = $userModel->find($id);
        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $data = [
            'nip' => $this->request->getPost('nip'),
            'gelar_depan' => $this->request->getPost('gelar_depan'),
            'nama' => $this->request->getPost('nama'),
            'gelar_belakang' => $this->request->getPost('gelar_belakang'),
            'role' => $this->request->getPost('role'),
            'kode_bidang' => $this->request->getPost('kode_bidang'),
            'status' => $this->request->getPost('status'),
            'jabatan_struktural' => $this->request->getPost('jabatan_struktural'),
        ];
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $userModel->update($id, $data);
        return redirect()->to('/admin/users');
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);
        return redirect()->to('/admin/users');
    }
}
