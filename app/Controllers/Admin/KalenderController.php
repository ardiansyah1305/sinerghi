<?php

namespace App\Controllers\Admin;

use App\Models\CalenderModel;
use CodeIgniter\Controller;

class KalenderController extends Controller
{   
    protected $calenderModel;

    public function __construct()
    {
        $this->calenderModel = new CalenderModel();
    }

    public function index()
{
    
    $calenderModel = new CalenderModel();
    
    // $search = $this->request->getGet('search');
    // $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

    // if ($search) {
    //     $calender = $calenderModel->like('title', $search)->paginate(20, 'default');
    // } else {
    //     $calender = $calenderModel->paginate(20, 'default');
    // }

    // $data = [
        
    //     'pager' => $calenderModel->pager,
    //     'currentPage' => $currentPage,
    //     'search' => $search,
    // ];

    
    $data['calenders'] = $calenderModel->findAll();

    return view('admin/kalender/index', $data);
}

    public function create()
{
    $data = [
        'title' => $this->request->getPost('title'),
        'description' => $this->request->getPost('description'),
        'start' => $this->request->getPost('start'),
        'end' => $this->request->getPost('end')
    ];
    $model->insert($data);
    // $calenderModel = new CalenderModel();

    // $data = ['calenders' => $calenderModel->findAll(),];

    return view('admin/kalender/create', $data);
}

    public function store()
{
    $calenderModel = new CalenderModel();

    $data = [
        'title' => $this->request->getPost('title'),
        'description' => $this->request->getPost('description'),
        'start' => $this->request->getPost('start'),
        'end' => $this->request->getPost('end')
    ];

    // Validasi input
    $validation = \Config\Services::validation();

    $rules = [
        'title' => 'required',
        'description' => 'required',
        'start' => 'required',
        'end' => 'required',
    ];

    if (!$this->validate($rules)) {
        session()->setFlashdata('error_kalender', 'Harap isi semua data yang diperlukan.');
        return redirect()->back()->withInput()->with('validation', $this->validator);
    }

    // Proses simpan data
    try {
        $calenderModel->save($data);
        session()->setFlashdata('success_kalender', 'Data kalender berhasil ditambahkan.');
    } catch (\Exception $e) {
        session()->setFlashdata('error_kalender', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
    }

    return redirect()->to('/admin/kalender/');
}

    public function edit($id)
{
    // $calenderModel = new CalenderModel();
    
    $data['title'] = $calenderModel->find($id);

    return view('admin/kalender/edit', $data);
}

    public function update($id)
{
    $calenderModel = new CalenderModel();

    $data = [
        'title' => $this->request->getPost('title'),
        'description' => $this->request->getPost('description'),
        'start' => $this->request->getPost('start'),
        'end' => $this->request->getPost('end'),
    ];

    // Validasi input
    $validation = \Config\Services::validation();

    $rules = [
        'title' => 'required',
        'description' => 'required',
        'start' => 'required',
        'end' => 'required',
    ];

    if (!$this->validate($rules)) {
        session()->setFlashdata('error_kalender', 'Harap isi semua data yang diperlukan.');
        return redirect()->back()->withInput()->with('validation', $this->validator);
    }

    // Proses update data
    try {
        $calenderModel->update($id, $data);
        session()->setFlashdata('success_kalender', 'Data kalender berhasil diperbarui.');
    } catch (\Exception $e) {
        session()->setFlashdata('error_kalender', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
    }

    return redirect()->to('/admin/kalender/');
}

    public function delete($id)
    {
        $calenderModel = new CalenderModel();
        $calenderModel->delete($id);
        return redirect()->to('/admin/kalender/');
    }
}
