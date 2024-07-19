<?php

namespace App\Controllers;

use App\Models\ContentModel;
use CodeIgniter\Controller;

class AdminController extends Controller
{
    public function index()
    {
        $contentModel = new ContentModel();
        $contents = $contentModel->findAll();
        $categories = $contentModel->where('parent_id', 0)->findAll();
        $categoryMap = [];
        foreach ($categories as $category) {
            $categoryMap[$category['id']] = $category['judul'];
        }

        $data = [
            'contents' => $contents,
            'categories' => $categoryMap
        ];

        return view('admin/dashboard', $data);
    }

    public function create()
    {
        $contentModel = new ContentModel();
        $data['categories'] = $contentModel->where('parent_id', 0)->findAll();
        return view('admin/create', $data);
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
        return redirect()->to('/admin');
    }

    public function edit($id)
    {
        $contentModel = new ContentModel();
        $data['content'] = $contentModel->find($id);
        $data['categories'] = $contentModel->where('parent_id', 0)->findAll();
        return view('admin/edit', $data);
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
        return redirect()->to('/admin');
    }

    public function delete($id)
    {
        $contentModel = new ContentModel();
        $contentModel->delete($id);
        return redirect()->to('/admin');
    }

    public function addCategory()
    {
        $contentModel = new ContentModel();
        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => '',
            'unit_terkait' => '',
            'tanggal' => date('Y-m-d'),
            'file_upload' => '',
            'parent_id' => 0
        ];
        $contentModel->save($data);
        return redirect()->to('/admin');
    }
}
