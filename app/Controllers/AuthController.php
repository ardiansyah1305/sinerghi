<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        helper(['form']);
        $data = [];
        echo view('auth/login', $data);
    }

    public function loginAuth()
    {
        $session = session();
        $model = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $recaptchaResponse = $this->request->getVar('g-recaptcha-response');

        // Verify reCAPTCHA
        $secretKey = '6LdghBUqAAAAALcB56rq_oyTXV_e1L7LDYbWdOAk';
        $credential = array(
            'secret' => $secretKey,
            'response' => $recaptchaResponse
        );

        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);
        $status = json_decode($response, true);

        if (!$status['success']) {
            $session->setFlashdata('msg', 'CAPTCHA verification failed');
            return redirect()->to('/login');
        }

        $data = $model->where('username', $username)->first();

        if ($data) {
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'id'       => $data['id'],
                    'username' => $data['username'],
                    'role'     => $data['role'], // Tambahkan role ke data sesi
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);

                // Cek role dan arahkan ke dashboard yang sesuai
                if ($data['role'] == '1') {
                    return redirect()->to('/admin/dashboard');
                } else {
                    return redirect()->to('/dashboard');
                }
            } else {
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username not Found');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
