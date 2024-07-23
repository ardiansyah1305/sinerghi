<?php

namespace App\Controllers\Admin;

use App\Models\ContentModel;
use App\Models\CategoryModel;
use CodeIgniter\Controller;

class ReferensiController extends Controller
{
    public function index()
    {
        // Pastikan pengguna sudah login
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Ambil user_id dari session
        $userId = $session->get('id');
        if (!$userId) {
            log_message('error', 'User ID not found in session.');
            return redirect()->to('/login'); // Arahkan ke halaman login jika user_id tidak ditemukan
        }

        $contentModel = new ContentModel();
        $categoryModel = new CategoryModel();
        $contents = $contentModel->findAll();
        $categories = $categoryModel->findAll();
        $categoryMap = [];
        foreach ($categories as $category) {
            $categoryMap[$category['id']] = $category['judul'];
        }

        $data = [
            'contents' => $contents,
            'categories' => $categoryMap
        ];

        return view('admin/referensi/referensi', $data);
    }

    public function create()
    {
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();
        return view('admin/referensi/create', $data);
    }

    public function store()
    {
        $contentModel = new ContentModel();
        $file = $this->request->getFile('file_upload');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/pdf', $newName);
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'unit_terkait' => $this->request->getPost('unit_terkait'),
            'tanggal' => $this->request->getPost('tanggal'),
            'file_upload' => $newName,
            'parent_id' => $this->request->getPost('parent_id')
        ];
        $contentModel->save($data);
        return redirect()->to('/admin/referensi');
    }

    public function edit($id)
    {
        $contentModel = new ContentModel();
        $categoryModel = new CategoryModel();
        $data['content'] = $contentModel->find($id);
        $data['categories'] = $categoryModel->findAll();
        return view('admin/referensi/edit', $data);
    }

    public function update($id)
    {
        $contentModel = new ContentModel();
        $file = $this->request->getFile('file_upload');
        $newName = $this->request->getPost('existing_file');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/pdf', $newName);
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'unit_terkait' => $this->request->getPost('unit_terkait'),
            'tanggal' => $this->request->getPost('tanggal'),
            'file_upload' => $newName,
            'parent_id' => $this->request->getPost('parent_id')
        ];
        $contentModel->update($id, $data);
        return redirect()->to('/admin/referensi');
    }

    public function delete($id)
    {
        $contentModel = new ContentModel();
        $contentModel->delete($id);
        return redirect()->to('/admin/referensi');
    }

    public function addCategory()
    {
        $categoryModel = new CategoryModel();
        $data = [
            'judul' => $this->request->getPost('judul')
        ];
        $categoryModel->save($data);
        return redirect()->to('/admin/referensi');
    }
}
