<?php

namespace App\Controllers;

use App\Models\PegawaiModel;
use App\Models\JabatanModel;
use App\Models\UnitKerjaModel;
use App\Models\StatuspegawaiModel;
use App\Models\StatuspernikahanModel;
use App\Models\JenjangpangkatModel;
use App\Models\AgamaModel;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $pegawaiModel;
    protected $jabatanModel;
    protected $statuspegawaiModel;
    protected $statuspernikahanModel;
    protected $jenjangpangkatModel;
    protected $agamaModel;
    protected $userModel;

    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
        $this->jabatanModel = new JabatanModel();
        $this->statuspegawaiModel = new StatuspegawaiModel();
        $this->statuspernikahanModel = new StatuspernikahanModel();
        $this->jenjangpangkatModel = new JenjangpangkatModel();
        $this->agamaModel = new AgamaModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Get the logged-in user's ID
        $session = session();
        $userId = $session->get('id');
        
        if (!$userId) {
            return redirect()->to('/login');
        }
        
        // Get the employee ID associated with the user
        $user = $this->userModel->find($userId);
        
        if (!$user || !isset($user['pegawai_id'])) {
            return redirect()->to('/dashboard')->with('error', 'Data pegawai tidak ditemukan.');
        }
        
        $pegawaiId = $user['pegawai_id'];
        
        // Get detailed employee information
        $pegawai = $this->pegawaiModel->getDetailedPegawai($pegawaiId);
        
        if (!$pegawai) {
            return redirect()->to('/dashboard')->with('error', 'Data pegawai tidak ditemukan.');
        }
        
        // Format dates for display
        if (!empty($pegawai['tanggal_lahir'])) {
            $pegawai['tanggal_lahir_formatted'] = date('d-m-Y', strtotime($pegawai['tanggal_lahir']));
        } else {
            $pegawai['tanggal_lahir_formatted'] = '-';
        }
        
        if (!empty($pegawai['tmt'])) {
            $pegawai['tmt_formatted'] = date('d-m-Y', strtotime($pegawai['tmt']));
        } else {
            $pegawai['tmt_formatted'] = '-';
        }
        
        $data = [
            'title' => 'Profil Pegawai',
            'pegawai' => $pegawai
        ];
        
        return view('profile/index', $data);
    }
    
    public function edit()
    {
        // Get the logged-in user's ID
        $session = session();
        $userId = $session->get('id');
        
        if (!$userId) {
            return redirect()->to('/login');
        }
        
        // Get the employee ID associated with the user
        $user = $this->userModel->find($userId);
        
        if (!$user || !isset($user['pegawai_id'])) {
            return redirect()->to('/dashboard')->with('error', 'Data pegawai tidak ditemukan.');
        }
        
        $pegawaiId = $user['pegawai_id'];
        
        // Get detailed employee information
        $pegawai = $this->pegawaiModel->getDetailedPegawai($pegawaiId);
        
        if (!$pegawai) {
            return redirect()->to('/dashboard')->with('error', 'Data pegawai tidak ditemukan.');
        }
        
        $data = [
            'title' => 'Edit Profil',
            'pegawai' => $pegawai,
            'agama' => $this->agamaModel->findAll(),
            'status_pernikahan' => $this->statuspernikahanModel->findAll(),
            'jenjang_pangkat' => $this->jenjangpangkatModel->findAll()
        ];
        
        return view('profile/edit', $data);
    }
    
    public function update()
    {
        // Get the logged-in user's ID
        $session = session();
        $userId = $session->get('id');
        
        if (!$userId) {
            return redirect()->to('/login');
        }
        
        // Get the employee ID associated with the user
        $user = $this->userModel->find($userId);
        
        if (!$user || !isset($user['pegawai_id'])) {
            return redirect()->to('/profile')->with('error', 'Data pegawai tidak ditemukan.');
        }
        
        $pegawaiId = $user['pegawai_id'];
        
        // Validate and update the allowed fields
        $rules = [
            'tempat_lahir' => 'permit_empty|max_length[100]',
            'tanggal_lahir' => 'permit_empty|valid_date[Y-m-d]',
            'jenis_kelamin' => 'permit_empty|in_list[L,P]',
            'agama' => 'permit_empty|numeric',
            'status_pernikahan' => 'permit_empty|numeric',
            'alamat' => 'permit_empty|max_length[255]',
            'no_telp' => 'permit_empty|max_length[20]',
            'email' => 'permit_empty|valid_email|max_length[100]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $updateData = [
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'agama' => $this->request->getPost('agama'),
            'status_pernikahan' => $this->request->getPost('status_pernikahan'),
            'alamat' => $this->request->getPost('alamat'),
            'no_telp' => $this->request->getPost('no_telp'),
            'email' => $this->request->getPost('email'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Update the employee data
        $updated = $this->pegawaiModel->update($pegawaiId, $updateData);
        
        if ($updated) {
            return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui.');
        } else {
            return redirect()->to('/profile')->with('error', 'Gagal memperbarui profil. Silakan coba lagi.');
        }
    }
}
