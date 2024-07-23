<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class RegisterController extends Controller
{
    public function index()
    {
        helper(['form']);
        echo view('auth/register');
    }

    public function store()
    {
        helper(['form']);
        $rules = [
            'nip'       => 'required',
            'password'  => 'required|min_length[6]|max_length[255]',
            'confpassword' => 'matches[password]'
        ];

        if ($this->validate($rules)) {
            $model = new UserModel();
            $nip = $this->request->getVar('nip');
            $password = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);

            $data = $model->where('nip', $nip)->first();

            if ($data) {
                $model->update($data['id'], ['password' => $password]);

                return redirect()->to('/login')->with('success', 'Password berhasil diperbarui');
            } else {
                return redirect()->back()->with('error', 'NIP tidak ditemukan');
            }
        } else {
            $data['validation'] = $this->validator;
            echo view('auth/register', $data);
        }
    }
}
