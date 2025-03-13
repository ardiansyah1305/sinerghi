<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\PegawaiModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
    protected $userModel;
    protected $pegawaiModel;
    protected $roleModel;

    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
        $this->userModel = new UserModel();
    }
    public function index()
    {
        $userModel = new UserModel();
        $pegawaiModel = new PegawaiModel();
        $RoleModel = new RoleModel();

        $data = [
            'baseURL' => base_url(),
            'users' => $userModel->getAllUserWithNama(),
            'pegawai' => $pegawaiModel->getAllPegawai(),
            'role' => $RoleModel->findAll(),
        ];

        // dd($data);
        return view('admin/users/index', $data);
    }

    public function create()
    {
        $pegawaiModel = new PegawaiModel();
        $RoleModel = new RoleModel();

        $data = [
            'pegawai' => $pegawaiModel->findAll(),
            'role' => $RoleModel->findAll(),
        ];
        return view('admin/users/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        // Validation rules for the form inputs
        $validation->setRules([
            'pegawai_id' => [
                'label' => 'Pegawai',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Pegawai harus dipilih.',
                ]
            ],
            'username_ldap' => [
                'label' => 'USERNAME LDAP',
                'rules' => 'required',
                'errors' => [
                    'required' => 'USERNAME LDAP tidak boleh Kosong.',
                ]
            ],
            'role_id' => [
                'label' => 'Role',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Role User harus dipilih.',
                ]
            ],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),
            ]);
        }

        // if ($this->request->getPost('password') !== $this->request->getPost('confirm_password')) {
        //     return $this->response->setJSON([
        //         'status' => 'error',
        //         'errors' => [
        //             'confirm_password' => 'Konfirmasi password tidak cocok dengan password.',
        //         ],
        //     ]);
        // }

        $pegawai_id = $this->request->getPost('pegawai_id');
        $userModel = new UserModel();

        // Manual validation for uniqueness
        if ($userModel->where('pegawai_id', $pegawai_id)->countAllResults() > 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => [
                    'pegawai_id' => 'User sudah terdaftar.',
                ],
            ]);
        }

        $data = [
            'pegawai_id' => $pegawai_id,
            'username_ldap' => $this->request->getPost('username_ldap'),
            // 'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role_id' => $this->request->getPost('role_id'),
        ];

        try {
            $userModel->insert($data);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data User berhasil disimpan.',
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ]);
        }
    }


    public function edit($id)
    {
        $userModel = new UserModel();
        $pegawaiModel = new PegawaiModel();
        $RoleModel = new RoleModel();



        $data = [
            'user' => $userModel->find($id),
            'pegawai' => $userModel->getAllUserWithNamaId($id),
            'role' => $RoleModel->findAll(),
        ];

        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();

        // Validation rules for the form inputs
        $validation->setRules([
            'old_password' => [
                'label' => 'Password Lama',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password Lama tidak boleh Kosong.',
                ]
            ],
            'password' => [
                'label' => 'Password Baru',
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password Baru tidak boleh Kosong.',
                    'min_length' => 'Password harus terdiri dari minimal 6 karakter.',
                ]
            ],
            'confirm_password' => [
                'label' => 'Konfirmasi Password Baru',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi Password tidak boleh Kosong.',
                    'matches' => 'Konfirmasi password tidak cocok dengan password baru.',
                ]
            ],
            'role_id' => [
                'label' => 'Role',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Role User harus dipilih.',
                ]
            ],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),
            ]);
        }

        // Cek apakah user ada
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => [
                    'old_password' => 'User tidak ditemukan.',
                ]
            ]);
        }

        // Verifikasi old password
        if (!password_verify($this->request->getPost('old_password'), $user['password'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => [
                    'old_password' => 'Password Lama tidak sesuai.',
                ]
            ]);
        }

        // Data yang akan diperbarui
        $data = [
            'pegawai_id' => $this->request->getPost('pegawai_id'),
            'role_id' => $this->request->getPost('role_id'),
        ];

        // Update password jika ada
        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        // Update data user
        try {
            $userModel->update($id, $data);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data User berhasil diperbarui.',
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ]);
        }
    }



    public function delete($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);
        return redirect()->to('/admin/users');
    }
}
